<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ReplaceOrphanedPageImages extends Migration
{
    private function replaceMissingImages($content)
    {
        return preg_replace_callback("/(<img\\b[^>]*\\bsrc=[\"'])([^\"']+)([\"'])/i", function ($matches) {
            $path = parse_url($matches[2], PHP_URL_PATH);
            if (!$path || strpos($path, '/') !== 0 || is_file(public_path(ltrim($path, '/')))) {
                return $matches[0];
            }

            return $matches[1] . '/images/missing-media.svg' . $matches[3];
        }, $content);
    }

    public function up()
    {
        foreach (DB::table('pages')->get() as $page) {
            $updates = [];
            $content = $this->replaceMissingImages($page->content);
            if ($content !== $page->content) {
                $updates['content'] = $content;
            }

            $extras = json_decode($page->extras, true);
            if (is_array($extras)) {
                foreach (['content_rus', 'content'] as $field) {
                    if (isset($extras[$field])) {
                        $extras[$field] = $this->replaceMissingImages($extras[$field]);
                    }
                }
                if (json_encode($extras) !== $page->extras) {
                    $updates['extras'] = json_encode($extras);
                }
            }

            if (!empty($updates)) {
                DB::table('pages')->where('id', $page->id)->update($updates);
            }
        }
    }

    public function down()
    {
        // Original orphaned media paths cannot be restored without the files.
    }
}
