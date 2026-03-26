<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function amountInWordsMYR($number,$currency='Ringgit')
{
    // Convert to float and remove any formatting (commas, etc.)
    if (is_string($number)) {
        $number = (float) str_replace(',', '', $number);
    }
    $number = (float) $number;
    
    $no = floor($number);
    $decimal = (int) round(($number - $no) * 100);

    // Handle zero case
    if ($no == 0) {
        $result = 'Zero';
    } else {
        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
            17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
            50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        $scales = ['', 'Thousand', 'Million', 'Billion'];
        $str = [];
        $scaleIndex = 0;

        while ($no > 0) {
            $numberPart = $no % 1000;
            $no = floor($no / 1000);

            if ($numberPart) {
                $hundreds = floor($numberPart / 100);
                $remainder = $numberPart % 100;
                $text = '';

                // Add hundreds part
                if ($hundreds) {
                    $text .= $words[$hundreds] . ' Hundred';
                    if ($remainder > 0) {
                        $text .= ' and ';
                    }
                }

                // Add tens and ones part
                if ($remainder > 0) {
                    if ($remainder < 21) {
                        $text .= $words[$remainder];
                    } else {
                        $tens = floor($remainder / 10) * 10;
                        $ones = $remainder % 10;
                        $text .= $words[$tens];
                        if ($ones > 0) {
                            $text .= ' ' . $words[$ones];
                        }
                    }
                }

                // Add scale (Thousand, Million, etc.)
                if ($scaleIndex > 0) {
                    $text .= ' ' . $scales[$scaleIndex];
                }

                $str[] = trim($text);
            }
            $scaleIndex++;
        }

        $result = implode(' ', array_reverse($str));
    }

    $sen = '';
    if ($decimal > 0) {
        if ($decimal < 21) {
            $sen = ' and ' . $words[$decimal] . ' Sen';
        } else {
            $tens = floor($decimal / 10) * 10;
            $ones = $decimal % 10;
            $sen = ' and ' . $words[$tens];
            if ($ones > 0) {
                $sen .= ' ' . $words[$ones];
            }
            $sen .= ' Sen';
        }
    }

    return $result . ' '.$currency . $sen . ' Only';
}
