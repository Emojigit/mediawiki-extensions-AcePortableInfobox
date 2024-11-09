<?php
// Copyright (c) 2024 1F616EMO
// SPDX-License-identifier: GPL-2.0-or-later

namespace MediaWiki\Extension\AcePortableInfobox;

use MediaWiki\Config\Config;
use MediaWiki\Extension\CodeEditor\Hooks\CodeEditorGetPageLanguageHook;
use MediaWiki\Title\Title;
use MediaWiki\Revision\RevisionRecord;
use WikiPage;

class CodeEditorHooks implements CodeEditorGetPageLanguageHook
{
    /**
     * @param Title $title
     * @param string|null &$languageCode
     * @param string $model
     * @param string $format
     * @return bool
     */
    public function onCodeEditorGetPageLanguage(Title $title, ?string &$languageCode, string $model, string $format)
    {
        if (
            $title->exists()
            && $title->getNamespace() === NS_TEMPLATE
            && str_contains(strtolower($title), 'infobox')
        ) {
            $identity = $title->toPageIdentity();
            $wikipage = new WikiPage($identity);
            $content = $wikipage->getContent(RevisionRecord::RAW);
            if (str_contains($content->getText(), '<infobox')) {
                $languageCode = 'xml';
                return false;
            }
        }

        return true;
    }
}
