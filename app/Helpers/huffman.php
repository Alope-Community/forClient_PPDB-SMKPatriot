<?php

namespace App\Helpers;

class HuffmanNode
{
    public $char;
    public $freq;
    public $left;
    public $right;

    public function __construct(
        $char,
        $freq,
        $left = null,
        $right = null
    ) {
        $this->char = $char;
        $this->freq = $freq;
        $this->left = $left;
        $this->right = $right;
    }
}

class Huffman
{
    /**
     * COMPRESS
     */
    public static function compress($data)
    {
        // Hitung frekuensi karakter
        $frequency = [];

        for ($i = 0; $i < strlen($data); $i++) {

            $char = $data[$i];

            if (!isset($frequency[$char])) {
                $frequency[$char] = 0;
            }

            $frequency[$char]++;
        }

        // Buat node
        $nodes = [];

        foreach ($frequency as $char => $freq) {

            $nodes[] = new HuffmanNode(
                $char,
                $freq
            );
        }

        // Bangun tree Huffman
        while (count($nodes) > 1) {

            usort($nodes, function ($a, $b) {
                return $a->freq - $b->freq;
            });

            $left = array_shift($nodes);
            $right = array_shift($nodes);

            $parent = new HuffmanNode(
                null,
                $left->freq + $right->freq,
                $left,
                $right
            );

            $nodes[] = $parent;
        }

        $tree = $nodes[0];

        // Generate code
        $codes = [];

        self::generateCodes(
            $tree,
            "",
            $codes
        );

        // Encode
        $encoded = "";

        for ($i = 0; $i < strlen($data); $i++) {

            $encoded .=
                $codes[$data[$i]];
        }

        return [
            'encoded' => $encoded,
            'codes' => $codes
        ];
    }

    /**
     * GENERATE CODE
     */
    private static function generateCodes(
        $node,
        $code,
        &$codes
    ) {
        if ($node == null) {
            return;
        }

        // Leaf node
        if ($node->char !== null) {

            $codes[$node->char] =
                $code ?: "0";
        }

        self::generateCodes(
            $node->left,
            $code . "0",
            $codes
        );

        self::generateCodes(
            $node->right,
            $code . "1",
            $codes
        );
    }

    /**
     * DECOMPRESS
     */
    public static function decompress(
        $encoded,
        $codes
    ) {

        $reverseCodes =
            array_flip($codes);

        $current = "";
        $decoded = "";

        for ($i = 0; $i < strlen($encoded); $i++) {

            $current .= $encoded[$i];

            if (isset($reverseCodes[$current])) {

                $decoded .=
                    $reverseCodes[$current];

                $current = "";
            }
        }

        return $decoded;
    }
}