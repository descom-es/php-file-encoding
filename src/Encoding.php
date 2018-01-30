<?php

namespace Descom\File;

class Encoding
{
    /**
     * Encode file.
     *
     * @param string $file               Original file
     * @param string $encoding_to        Encoding to encode file
     * @param string $encodings_detected Ordered list of encodings
     *
     * @return bool
     */
    public function encodeFile($file, $encoding_to = 'UTF-8', $encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252')
    {
        $encoding_original = $this->detectEncoding($file, $encodings_detected);

        if ($encoding_original !== false && $encoding_original != $encoding_to) {
            try {
                $fileW = $file.'.tmp';
                $handleR = @fopen($file, 'r');
                $handleW = @fopen($fileW, 'w');
                if ($handleR && $handleW) {
                    while ($line = fgets($handleR, 4096)) {
                        if (fwrite($handleW, mb_convert_encoding($line, $encoding_to, $encoding_original), 4096) === false) {
                            fclose($handleR);
                            fclose($handleW);
                            unlink($fileW);

                            return false;
                        }
                    }
                    fclose($handleR);
                    fclose($handleW);
                    if (rename($fileW, $file) === false) {
                        unlink($fileW);

                        return false;
                    }
                } else {
                    return false;
                }
            } catch (Exception $e) {
                if (file_exits($fileW)) {
                    unlink($fileW);
                }

                return false;
            }
        }

        return $this->checkEncoding($file, $encoding_to);
    }

    /**
     * Detect file encoding.
     *
     * @param string $file               Original file
     * @param string $encodings_detected Ordered list of encodings
     *
     * @return mixed String encoding or false
     */
    public function detectEncoding($file, $encodings_detected)
    {
        $encodings = explode(',', $encodings_detected);

        if (count($encodings)) {
            $handle = @fopen($file, 'r');
            if ($handle) {
                while ($line = fgets($handle, 4096)) {
                    $encoding = mb_detect_encoding($line, $encodings_detected, true);
                    if ($encoding != $encodings[0]) {
                        fclose($handle);

                        return $encoding;
                    }
                }
                fclose($handle);

                return $encodings[0];
            }
        }

        return false;
    }

    /**
     * Check if file encoding matches encoding_to.
     *
     * @param string $file Original file
     *
     * @return bool
     */
    public function checkEncoding($file, $encoding_to)
    {
        $handle = @fopen($file, 'r');

        if ($handle) {
            while ($line = fgets($handle, 4096)) {
                if (!mb_check_encoding($line, $encoding_to)) {
                    fclose($handle);

                    return false;
                }
            }
            fclose($handle);
        } else {
            return false;
        }

        return true;
    }
}
