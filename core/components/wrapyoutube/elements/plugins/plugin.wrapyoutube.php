<?php
/** @var modX $modx */
switch ($modx->event->name) {
    case 'OnWebPagePrerender':
        $excluded = $modx->getOption('wrapyoutube_excluded_templates', null, '');
        if ($excluded !== '') {
            $template = $modx->resource->template;
            $tmpl_arr = explode(',', $excluded);
            if (in_array($template, $tmpl_arr)) {
                return;
            }
        }
        $tpl = $modx->getOption('wrapyoutube_tpl', null, 'tpl.wrapYoutube');
        if (!$modx->getObject('modChunk', array('name' => $tpl))) {
            return;
        }
        require_once $modx->getOption('core_path') . 'components/wrapyoutube/lib/simple_html_dom.php';
        $html= new simple_html_dom();
        $html->load($modx->resource->_output, false, false, DEFAULT_BR_TEXT);
        
        $iframes = $html->find('iframe');
        if (!$iframes) {
            return;
        }
        foreach($iframes as $iframe) {
            if (strpos($iframe->src, 'youtube.com') !== false) {
                $placeholders = array(
                    'id' => '',
                    'img' => '',
                    'link' => $iframe->src,
                    'embed' => $iframe->src,
                    'width' => $iframe->width,
                    'height' => $iframe->height
                );
                $matches = array();
                preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $iframe->src, $matches);
                if(isset($matches[2]) && $matches[2] != ''){
                    $placeholders['id'] = $matches[2];
                    $placeholders['img'] = "//img.youtube.com/vi/{$placeholders['id']}/hqdefault.jpg";
                    $placeholders['embed'] = "//www.youtube.com/embed/{$placeholders['id']}?autoplay=1";
                }
                $iframe->outertext = $modx->getChunk($tpl, $placeholders);
            }
        }
        $css = $modx->getOption('wrapyoutube_front_css', null, '[[++assets_url]]components/wrapyoutube/css/web/default.css', true);
        $js  = $modx->getOption('wrapyoutube_front_js',  null, '[[++assets_url]]components/wrapyoutube/js/web/default.js',   true);
        if ($css) {
            $css = str_replace('[[++assets_url]]', $modx->getOption('assets_url'), $css);
            $html->find('head', 0)->innertext .= '<link rel="stylesheet" href="'.$css.'" type="text/css" />' . PHP_EOL;
        }
        if ($js) {
            $js = str_replace('[[++assets_url]]', $modx->getOption('assets_url'), $js);
            $html->find('body', 0)->innertext .= '<script type="text/javascript" src="'.$js.'"></script>' . PHP_EOL;
        }
        $modx->resource->_output = $html;
        break;
    default:
        break;
}
return;