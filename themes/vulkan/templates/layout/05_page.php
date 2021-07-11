<?php $this->layout('theme::layout/00_layout') ?>

<?php if ($params['html']['repo']) { ?>
    <a href="https://github.com/<?= $params['html']['repo']; ?>" target="_blank" id="github-ribbon" class="hidden-print"><img src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
<?php } ?>
<div class="container-fluid fluid-height wrapper">
    <div class="row columns content">
        <div class="left-column article-tree col-sm-3 hidden-print">
            <!-- For Mobile -->
            <div class="responsive-collapse">
                <button type="button" class="btn btn-sidebar" id="menu-spinner-button">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="sub-nav-collapse" class="sub-nav-collapse">
                <div class="nav-logo">
                    Vulkan Tutorial
                </div>

                <!-- Language picker -->
                <div class="language-picker">
                <?php
                $language_pickers = array();
                foreach($params['languages'] as $lang => $lang_name) {
                    if ($lang === $params['language']) {
                        $language_pickers[] = '<a href="/Introduction">' . $lang_name . '</a>';
                    } else {
                        $language_pickers[] = '<a href="/' . $lang . '/Introduction">' . $lang_name . '</a>';
                    }
                }
                echo implode(' / ', $language_pickers);
                ?>
                </div>

                <!-- Navigation -->
                <div style="padding-top: 20px; padding-bottom: 20px; background: #272525">
                <?php
                $rendertree = $tree;
                $path = '';

                if ($page['language'] !== '') {
                    $rendertree = $tree[$page['language']];
                    $path = $page['language'];
                }

                echo $this->get_navigation($rendertree, $path, isset($params['request']) ? $params['request'] : '', $base_page, $params['mode']);
                ?>
                </div>

                <div class="sidebar-links">
                    <?php if (!empty($params['html']['links']) || !empty($params['html']['twitter']) || $params['html']['toggle_code']) { ?>

                        <!-- Links -->
                        <?php
                        foreach ($params['html']['links'] as $name => $url) {
                            echo '<a href="' . $url . '" target="_blank">' . $name . '</a><br>';

                            if ($name == "Support the website" || $name == "Vulkan Hardware Database") {
                                echo '<br>';
                            }
                        } ?>

                        <div id="toggleCodeBlock">
                        <?php if ($params['html']['toggle_code'] && $params['html']['float']) { ?>
                            <br />
                            <span class="code-buttons-text">Code blocks</span>
                            <div class="btn-group" role="group">
                              <button id="code-hide" class="btn btn-sm btn-default">No</button>
                              <button id="code-below" class="btn btn-sm btn-default">Below</button>
                              <button id="code-float" class="btn btn-sm btn-default">Inline</button>
                            </div>
                        <?php } else if ($params['html']['toggle_code']) { ?>
                            <a id="toggleCodeBlockBtn" href="#" onclick="toggleCodeBlocks();">Show Code Blocks Inline</a><br>
                        <?php } ?>
                        </div>

                        <!-- Twitter -->
                        <?php foreach ($params['html']['twitter'] as $handle) { ?>
                            <div class="twitter">
                                <hr/>
                                <iframe allowtransparency="true" frameborder="0" scrolling="no" style="width:162px; height:20px;" src="https://platform.twitter.com/widgets/follow_button.html?screen_name=<?= $handle; ?>&amp;show_count=false"></iframe>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

                <div style="color: #666; padding: 0 20px 0 20px; font-size: 90%">
                    This site is not affiliated with or endorsed by the Khronos Group. Vulkan® and the Vulkan logo are trademarks of the Khronos Group Inc.
                </div>
            </div>
        </div>
        <div class="right-column <?= $params['html']['float'] ? 'float-view' : ''; ?> content-area col-sm-9">
            <div class="content-page" style="position: relative;">
                <div class="adbox-side" style="position: absolute; left: calc(100% + 50px);">
                    <div id="waldo-tag-4310"></div>
                </div>

                <div class="adbox-side" style="position: absolute; left: -350px">
                    <div id="waldo-tag-4312"></div>
                </div>

                <?php if ($params['html']['search']) { ?>
                    <div id="tipue_search_content" style="display:none"></div>
                <?php } ?>

                <div class="doc_content">
                    <?= $this->section('content'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
