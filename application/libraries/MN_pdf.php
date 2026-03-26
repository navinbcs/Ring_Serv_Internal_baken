<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Mpdf\Mpdf;

class MN_pdf {

    public $pdf;

    public function __construct($params = [])
    {
        require_once FCPATH . 'vendor/autoload.php';

        $default = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => 10,
            'margin_bottom' => 10
        ];

        $config = array_merge($default, $params);

        $this->pdf = new Mpdf($config);
    }
}
