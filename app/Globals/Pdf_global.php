<?php
namespace App\Globals;
use PDF;
use App;
class Pdf_global
{
    public static function show_pdf($html, $orient = null, $footer = '', $paper_size = 'a4')
	{
		$html_b = Pdf_global::bootstrap($html);
        $pdf = App::make('snappy.pdf.wrapper');
        if($footer != '')
        {
	        $pdf->setOption('footer-right', $footer.' Page [page] of [topage]');
        }
        $pdf->loadHTML($html_b);
        if($orient != null)
        {
        	$pdf->setOrientation('landscape');
        }
        if($paper_size != null)
        {
        	$pdf->setPaper($paper_size);
        }
        $pdf->setOption('viewport-size','1366x1024');
        $pdf->setOption('page-width', '215.9');
        $pdf->setOption('page-height', '139.7');
        return $pdf->inline();
	}
	public static function show_pdfv2($html, $orient = null, $footer = '')
	{
		$html_b = Pdf_global::bootstrap($html);
        $pdf = App::make('snappy.pdf.wrapper');

        if($footer != '')
        {
	        $pdf->setOption('footer-right', $footer.' Page [page] of [topage]');
        }

        $pdf->loadHTML($html_b);

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