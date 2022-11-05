<?php
    namespace Todaymade\Daux\Extension;

    use League\CommonMark\ElementRendererInterface;
    use League\CommonMark\InlineParserContext;
    use League\CommonMark\HtmlElement;
    use League\CommonMark\Inline\Parser\InlineParserInterface;
    use League\CommonMark\Inline\Renderer\InlineRendererInterface;
    use League\CommonMark\Inline\Element\AbstractInline;
    use League\CommonMark\Inline\Element\Code;
    use League\CommonMark\Util\Xml;

    class VulkanLinkParser implements InlineParserInterface {
        public function getCharacters(): array {
            return ['v', 'V'];
        }

        public function parse(InlineParserContext $inlineContext): bool {
            $cursor = $inlineContext->getCursor();

            // Ensure that 'v' is the first character of this word
            $previousChar = $cursor->peek(-1);
            if ($previousChar !== null && $previousChar !== "\n" && $previousChar !== ' ' && $previousChar !== '(') {
                return false;
            }

            $functionName = $cursor->match('/^[vV]k[A-Z][A-Za-z0-9_]+/');

            if (empty($functionName)) {
                return false;
            }

            $inlineContext->getContainer()->appendChild(new Code($functionName));

            return true;
        }
    }

    class VulkanLinkRenderer implements InlineRendererInterface {
        public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer) {
            if (!($inline instanceof Code)) {
                throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
            }

            if (preg_match("/^[vV]k[A-Z][A-Za-z0-9_]+$/", $inline->getContent()) && strpos($inline->getContent(), "KHR") === false && strpos($inline->getContent(), "EXT") === false) {
                $attrs = [];
                $attrs['href'] = "https://www.khronos.org/registry/vulkan/specs/1.0/man/html/" . $inline->getContent() . ".html";

                return new HtmlElement('a', $attrs, new HtmlElement('code', [], $inline->getContent()));
            } else {
                $attrs = [];
                foreach ($inline->getData('attributes', []) as $key => $value) {
                    $attrs[$key] = Xml::escape($value);
                }

                return new HtmlElement('code', $attrs, Xml::escape($inline->getContent()));
            }
        }
    }

    class VulkanLinkProcessor extends \Todaymade\Daux\Processor {
        public function extendCommonMarkEnvironment(\League\CommonMark\Environment $environment) {
            // Turn Vulkan functions referenced in the text into code blocks
            $environment->addInlineParser(new VulkanLinkParser());

            // Turn code blocks consisting of Vulkan functions into links to the specification
            $environment->addInlineRenderer('League\CommonMark\Inline\Element\Code', new VulkanLinkRenderer());
        }
    }
?>