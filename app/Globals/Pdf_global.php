<?php
namespace App\Globals;
use PDF;
use App;
class Pdf_global
{
	public static function show_pdf($html, $orient = null,$footer = null)
	{
		$html_b = Pdf_global::bootstrap($html);
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('footer-right', $footer.' Page [page] of [topage]');
        $pdf->loadHTML($html_b);
        if($orient != null)
        {
        	$pdf->setOrientation('landscape');
        }
        return $pdf->inline();
	}
	public static function show_image($html)
	{
		$html_b = Pdf_global::bootstrap($html);
		// return $html_b;
        $pdf = App::make('snappy.image.wrapper');
        $pdf->loadHTML($html_b);
        return $pdf->download('card.jpg');
	}
	public static function show_image_url($html)
	{
		$html_b = Pdf_global::bootstrap($html);
        $pdf = App::make('snappy.image.wrapper');
        $pdf->loadHTML($html_b);
        return $pdf->download('card.jpg');
	}
	public static function bootstrap($html)
	{
		$data['html'] = $html;
		return view('pdf.body', $data);
	}
}