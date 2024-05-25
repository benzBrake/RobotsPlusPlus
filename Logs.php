<?php

/**
 * 蜘蛛来访日志插件，记录蜘蛛爬行的时间及其网址
 *
 * @package RobotsPlusPlus
 * @author  Ryan, YoviSun, Shion
 * @version 2.0.3
 * @update: 2020.05.30
 * @link http://doufu.ru
 */

include 'common.php';
include 'header.php';
include 'menu.php';
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
$robotsArchive = Typecho_Widget::widget('RobotsPlusPlus_Widget');
$options = Typecho_Widget::widget('Widget_Options');
?>
<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="container typecho-page-main">
            <div class="col-mb-12 typecho-list">
                <div class="typecho-list-operate clearfix">
                    <form method="get" action="<?php $options->adminUrl('extending.php'); ?>">
                        <input type="hidden" name="panel" value="RobotsPlusPlus/Logs.php"/>
                        <div class="operate">
                            <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox"
                                                                                   class="typecho-table-select-all"/></label>
                            <div class="btn-group btn-drop">
                                <button class="btn dropdown-toggle btn-s" type="button"><i
                                            class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?> <i
                                            class="i-caret-down"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a lang="<?php _e('你确认要删除这些记录吗?'); ?>"
                                           href="<?php $security->index('/action/robots-logs-edit?do=delete'); ?>"><?php _e('删除'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="search" role="search">
                            <div class="search-ip-group">
                                <input type="text" class="search-ip text-s"
                                       value="<?php echo htmlspecialchars($request->ip); ?>" name="ip"
                                       placeholder="<?php _e("请输入 IP 搜索"); ?>"/>
                                <a class="clear-search-ip" href="#" title="<?php _e("取消 IP 筛选"); ?>">x</a>
                            </div>
                            <select class="search-bot" name="bot">
                                <option value=""><?php _e('所有'); ?></option>
                                <?php foreach (RobotsPlusPlus_Util::getBotsList() as $id => $name) : ?>
                                    <option value="<?php echo $id; ?>" <?php if ($request->get('bot') == $id) : ?> selected="true" <?php endif; ?>><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="search-btn btn btn-s"><?php _e('筛选'); ?></button>
                        </div>
                    </form>
                </div>

                <form class="operate-form" method="post"
                      action="<?php $options->adminUrl('extending.php?panel=RobotsPlusPlus%2FLogs.php'); ?>">
                    <div class="typecho-table-wrap">
                        <table class="typecho-list-table">
                            <colgroup>
                                <col width="25"/>
                                <col width="260"/>
                                <col width="60"/>
                                <col width="30"/>
                                <col width="110"/>
                                <col width="205"/>
                                <col width="150"/>
                            </colgroup>
                            <thead>
                            <tr>
                                <th class="nodrag"></th>
                                <th>受访地址</th>
                                <th></th>
                                <th></th>
                                <th>蜘蛛名称</th>
                                <th>IP地址<a class="check-ip-location">查询位置</a></th>
                                <th class="typecho-radius-topright">日期</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($robotsArchive->have()) : ?>
                                <?php while ($robotsArchive->next()) : ?>
                                    <tr id="<?php $robotsArchive->theId(); ?>" class="even">
                                        <td><input type="checkbox" value="<?php $robotsArchive->lid(); ?>"
                                                   name="lid[]"/></td>
                                        <td colspan="2"><a
                                                    href="<?php echo str_replace("%23", "#", $robotsArchive->url); ?>"><?php echo urldecode(str_replace("%23", "#", $robotsArchive->url)); ?></a>
                                        </td>
                                        <td></td>
                                        <td data-bot="<?php $robotsArchive->bot(); ?>"
                                            class="robotx-bot-name"><?php $robotsArchive->botName(); ?></td>
                                        <td>
                                            <div class="robotx-ip"
                                                 data-ip="<?php $robotsArchive->ip(); ?>"><?php $robotsArchive->ip(); ?></div>
                                            <div class="robotx-location"></div>
                                        </td>
                                        <td><?php echo date('Y-m-d H:i:s', $robotsArchive->ltime); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr class="even">
                                    <td colspan="8">
                                        <h6 class="typecho-list-table-title"><?php _e('当前无蜘蛛日志'); ?></h6>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="typecho-list-operate clearfix">
                        <div class="operate">
                            <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox"
                                                                                   class="typecho-table-select-all"/></label>
                            <div class="btn-group btn-drop">
                                <button class="btn dropdown-toggle btn-s" type="button"><i
                                            class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?> <i
                                            class="i-caret-down"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a lang="<?php _e('你确认要删除这些记录吗?'); ?>"
                                           href="<?php $security->index('/action/robots-logs-edit?do=delete'); ?>"><?php _e('删除'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if ($robotsArchive->have()) : ?>
                            <ul class="typecho-pager">
                                <?php $robotsArchive->pageNav(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<style>
    .search-ip-group {
        position: relative;
        float: left;
        margin-right: 10px;
    }

    .clear-search-ip {
        background: #fff;
        padding: 2px 7px;
        position: absolute;
        right: 0;
        margin: 1px;
    }

    [id^="robots-log"] {
        cursor: move;
    }

    .check-ip-location {
        padding-left: 12px;
        cursor: pointer;
    }

    .robotx-bot-name,
    .robotx-ip {
        cursor: pointer;
    }
</style>
<?php
include 'copyright.php';
include 'common-js.php';
include 'table-js.php';
include 'footer.php';
?>
<script src="<?php Helper::options()->pluginUrl('RobotsPlusPlus/robotsplusplus.js'); ?>"></script>