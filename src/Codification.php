<?php

class Codification
{
    private $encoding_to;
    private $encodings_detected;

    public function __construct($encoding_to = 'UTF-8', $encodings_detected = 'UTF-8,ISO-8859-1,WINDOWS-1252')
    {
        $this->encoding_to = $encoding_to;
        $this->encodings_detected = $encodings_detected;
    }

    /**
     * Encode file.
     *
     * @param string $fileR              Original file
     * @param string $fileW              Encoded file
     * @param string &$encoding_original Original encoding
     * @param string &$encoding_final    Final encoding
     *
     * @return bool
     */
    public function EncodeFile($fileR, $fileW, &$encoding_original, &$encoding_final)
    {
        $encoding_original = $this->DetectEncoding($fileR);
        if ($encoding_original != $this->encoding_to) {
            if ($this->ConvertEncoding($fileR, $fileW, $encoding_original)) {
                $encoding_final = $this->DetectEncoding($fileW);

                return $this->CheckEncoding($fileW);
            } else {
                $encoding_final = '';

                return false;
            }
        } else {
            $encoding_final = $encoding_original;

            return $this->CheckEncoding($fileR);
        }
    }

    /**
     * Detect file encoding.
     *
     * @param string $fileR Original file
     *
     * @return string File encoding
     */
    public function DetectEncoding($fileR)
    {
        $handleR = @fopen($fileR, 'r');
        if ($handleR) {
            while ($line = fgets($handleR, 4096)) {
                $encoding = mb_detect_encoding($line, $this->encodings_detected, true);
                if ($encoding != $this->encoding_to) {
                    fclose($handleR);

                    return $encoding;
                }
            }
            fclose($handleR);
        }

        return $this->encoding_to;
    }

    /**
     * Encode file.
     *
     * @param string $fileR              Original file
     * @param string $fileW              Encoded file
     * @param string &$encoding_original Original encoding
     *
     * @return bool
     */
    public function ConvertEncoding($fileR, $fileW, $encoding_original)
    {
        try {
            $handleR = @fopen($fileR, 'r');
            $handleW = @fopen($fileW, 'w');

            if ($this->encoding_to != $encoding_original) {
                if ($handleR && $handleW) {
                    while ($line = fgets($handleR, 4096)) {
                        fwrite($handleW, mb_convert_encoding($line, $this->encoding_to, $encoding_original), 4096);
                    }
                }
                fclose($handleR);
                fclose($handleW);
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Check if file encoding matches encoding_to.
     *
     * @param string $fileR Original file
     *
     * @return bool
     */
    public function CheckEncoding($fileR)
    {
        $handleR = @fopen($fileR, 'r');

        if ($handleR) {
            while ($line = fgets($handleR, 4096)) {
                if (!mb_check_encoding($line, $this->encoding_to)) {
                    fclose($handleR);

                    return false;
                }
            }
            fclose($handleR);
        }

        return true;
    }
}
