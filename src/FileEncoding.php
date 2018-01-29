<?php

namespace Descom\File_Encoding;

class FileEncoding
{
    /**
     * Encode file.
     *
     * @param string $fileR               Original file
     * @param string &$encoding_to        Encoding to encode file
     * @param string &$encodings_detected Ordered list of encodings
     *
     * @return bool
     */
    public function encodeFile($file, $encoding_to = 'UTF-8', $encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252')
    {
        $encoding_original = $this->detectEncoding($file, $encodings_detected);
        if ($encoding_original != $encoding_to) {
            try {
                $fileW = '.temp';
                $handleR = @fopen($file, 'r');
                $handleW = @fopen($fileW, 'w');
                if ($handleR && $handleW) {
                    while ($line = fgets($handleR, 4096)) {
                        fwrite($handleW, mb_convert_encoding($line, $encoding_to, $encoding_original), 4096);
                    }
                    fclose($handleR);
                    fclose($handleW);
                    unlink($file);
                    rename($fileW, $file);
                } else {
                    fclose($handleR);
                    fclose($handleW);

                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        return $this->checkEncoding($file, $encoding_to);
    }

    /**
     * Detect file encoding.
     *
     * @param string $fileR              Original file
     * @param string $encodings_detected Ordered list of encodings
     *
     * @return string File encoding
     */
    public function detectEncoding($fileR, $encodings_detected)
    {
        $encodings = explode(',', $encodings_detected);
        $handleR = @fopen($fileR, 'r');
        if ($handleR && count($encodings)) {
            while ($line = fgets($handleR, 4096)) {
                $encoding = mb_detect_encoding($line, $encodings_detected, true);
                if ($encoding != $encodings[0]) {
                    fclose($handleR);

                    return $encoding;
                }
            }
            fclose($handleR);

            return $encodings[0];
        } else {
            return '';
        }
    }

    /**
     * Check if file encoding matches encoding_to.
     *
     * @param string $fileR Original file
     *
     * @return bool
     */
    public function checkEncoding($fileR, $encoding_to)
    {
        $handleR = @fopen($fileR, 'r');

        if ($handleR) {
            while ($line = fgets($handleR, 4096)) {
                if (!mb_check_encoding($line, $encoding_to)) {
                    fclose($handleR);

                    return false;
                }
            }
            fclose($handleR);
        } else {
            return false;
        }

        return true;
    }
}
