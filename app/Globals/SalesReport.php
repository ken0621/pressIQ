<?php                                                             
namespace App\Globals;
use App\Models\Tbl_variant;
use App\Models\Tbl_order;
use App\Models\Tbl_order_item;
use DB;

class SalesReport{
    public static function reportcount($shop_id = 0){
        $data = array();
        $date = date_create(date('Y-m-d'));
		
		$newdate = date_sub($date,date_interval_create_from_date_string("30 days"));
		
		$last30days = date_format($date,'Y-m-d');
		
		$order_count = Tbl_order::SelByShop($shop_id, $last30days)->count();
		$customer_count = Tbl_order::SelByShop($shop_id, $last30days)->where('customer_id','!=', 'null')
							   ->groupBy('customer_id')
							   ->get();
		
		$customer_count = count($customer_count);
		$strCustomerCount = ' customer';
		
		if($customer_count > 1){
			$strCustomerCount = ' customers';
		}
		$orderstr = ' order';
		if($order_count > 1){
		    $orderstr = ' orders';
		}
		$variant_count = Tbl_order::join('tbl_order_item','tbl_order_item.tbl_order_id','=','tbl_order.tbl_order_id')
		                  ->where('tbl_order.shop_id',$shop_id)
						  ->where('tbl_order.craeted_date','>=',$last30days)
						  ->count();
		$strVariant = ' variant';		   
		if($variant_count > 1){
		    $strVariant = ' variants';
		}
		$product_count = Tbl_order::join('tbl_order_item','tbl_order_item.tbl_order_id','=','tbl_order.tbl_order_id')
		                  ->join('tbl_variant','tbl_variant.variant_id','=','tbl_order_item.variant_id')
		                  ->where('tbl_order.shop_id',$shop_id)
						  ->where('tbl_order.craeted_date','>=',$last30days)
						  ->groupBy('tbl_variant.variant_product_id')
						  ->count();
	    $strproduct_count = ' product';
	    if($product_count > 1){
	        $strproduct_count = ' products';
	    }
		$data['customer_count']['num'] = $customer_count;
		$data['customer_count']['str'] = $customer_count.$strCustomerCount;
		$data['order_count']['num'] = $order_count;
		$data['order_count']['str'] = $order_count.$orderstr;
		$data['variant_count']['num'] = $variant_count;
		$data['variant_count']['str'] = $variant_count.$strVariant;
		$data['product_count']['num'] = $product_count;
		$data['product_count']['str'] = $product_count.$strproduct_count;
		return $data;
    }
    public static function monthlysale($shop_id, $startdate = '0000-00-00', $endate = '0000-00-00'){
        $data = array();
        // dd($endate);
        // dd($shop_id);
        $timeStart = strtotime($startdate);
        $timeEnd = strtotime($endate);
        $data['range'] = date('M d, Y',$timeStart).' - '.date('M d, Y',$timeEnd);
        $data['start'] = date('m/d/Y', $timeStart);
        $data['end'] = date('m/d/Y',$timeEnd);
        $explodeStart = explode("-", $startdate);
        $explodeEnd = explode("-",$endate);
        $min_date = min($timeStart, $timeEnd);
        $max_date = max($timeStart, $timeEnd);
        // dd(date('t',strtotime($endate)));
        $arrbetween = array();
        $i = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $i++;
        }   
        // dd($explodeStart);
        $month = $explodeStart[1];
        $year = $explodeStart[0];
        $mainArr = array();
        $dateArr = array();
        for($j = 0; $j <= $i; $j++){
            if($month > 12){
                $month = 1;
                $year++;
            }
            $tempStart = $year.'-'.$month.'-01';
            
            if($j == 0){
                $tempStart = $startdate;
                
            }
            $tempEnd = date('Y-m-t',strtotime($tempStart));
            if($j == $i){
                // $tempEnd = $endate;
                $tempEnd = date('Y-m-d', strtotime($endate . ' +1 day'));
            }
            
            $betweendate[0] = $tempStart;
            $betweendate[1] = $tempEnd;
            
            array_push($dateArr,$betweendate);
            $tempSEl = Tbl_order::where('shop_id',$shop_id)->whereBetween('craeted_date',$betweendate)->orderBy('customer_id','asc')->get();
            // $tempSEl = Tbl_order::where('shop_id',$shop_id)->where('craeted_date','>=',$betweendate[0])->where('craeted_date','<=',$betweendate[0])->orderBy('customer_id','asc')->get();
            $data['data'][$j]['monthStr'] = date('F Y', strtotime($tempStart));
            $totalGross = 0;
            $totalOrder = 0;
            $totalDiscount = 0;
            $totalRefund = 0;
            $totalNet = 0;
            $totalShipping = 0;
            $totalTax = 0;
            $totalSales = 0;
            $customerCount = 0;
            $customerArr = array();
            array_push($mainArr,$tempSEl);
            foreach($tempSEl as $sel){
                
                if(in_array($sel->customer_id,$customerArr)){
                    
                }
                else{
                    if($sel->customer_id != null){
                        array_push($customerArr, $sel->customer_id);
                        $customerCount++;
                    }
                    
                }
                
                $_item = Tbl_order_item::where('tbl_order_id',$sel->tbl_order_id)->where('archived',0)->get();
                $tempDiscountSub = 0;
                $tempDiscountMain = 0;
                
                $tempGrossRaw = 0;
                foreach($_item as $item){
                    $quantity = $item->quantity;
                    $price = $item->item_amount;
                    $tempRaw = $quantity * $price;
                    $tempGrossRaw += $tempRaw;
                    $SubVarDisc = $item->discount_var;
                    $discItem = $item->discount;
                    $tempDiscountSub1 = 0;
                    if($SubVarDisc != 'amount'){
                        $tempDiscountSub1 = $tempRaw * ($discItem / 100);
                    }
                    $tempDiscountSub += $tempDiscountSub1;
                }
                $totalShipping +=  $sel->shipping_amount;
                $discountMainVar = $sel->discount_var;
                $discountMainAmount = $sel->discount;
                if($discountMainVar != 'amount'){
                    $discountMainAmount = ($tempGrossRaw - $tempDiscountSub) * ($discountMainAmount / 100);
                }
                $totalGross += $tempGrossRaw;
                $totalDiscount += $discountMainAmount + $tempDiscountSub;
                $totalOrder++;
                // if($sel->isTaxExempt == 0 && $sel->hasTax == 1){
                //     $totalTax += ($tempGrossRaw - $discountMainAmount) * ($sel->tax_percentage / 100);
                // }
                
            }
            
            $totalNet = $totalGross - ($totalRefund - $totalDiscount);
            $totalSales = $totalNet + $totalShipping + $totalTax;
            $data['data'][$j]['totalGross'] = $totalGross;
            $data['data'][$j]['totalOrder'] = $totalOrder;
            $data['data'][$j]['totalDiscount'] = $totalDiscount;
            $data['data'][$j]['totalRefund'] = $totalRefund;
            $data['data'][$j]['totalNet'] = $totalNet;
            $data['data'][$j]['totalShipping'] = $totalShipping;
            $data['data'][$j]['totalTax'] = $totalTax;
            $data['data'][$j]['totalSales'] = $totalSales;
            $data['data'][$j]['customerCount'] = $customerCount;
            $month++;
        }
        // dd($mainArr);
        return $data;
        
    }
    
    /*FOR PRODUCT OR VARIANT OR CUSTOMER*/
    public static function SalesReportBy($type, $shop_id, $startdate = '0000-00-00', $endate = '0000-00-00'){
        $data = array();
        $data['range'] = date('M d Y', strtotime($startdate)).' - '.date('M d Y', strtotime($endate));
        $start = date('Y-m-d', strtotime($startdate));
        $end = date('Y-m-d', strtotime($endate));
        $date[0] = $start;
        $date[1] = $end;
        
        switch ($type)
        {
            case 'product':
                $_sel       = Tbl_order_item::order()->product();
                $columnkey  = 'product_id';
                break;
            case 'product_variant':
                $_sel       = Tbl_order_item::order()->variant();
                $columnkey  = 'variant_id';
                break;
            case 'customer':
                $_sel       = Tbl_order_item::order()->customer();
                $columnkey  = 'customer_id';
                break;
        }
                
        $_sel = $_sel->select(DB::raw('*, tbl_order.discount_var as mainVar, tbl_order_item.discount_var as subVar, tbl_order.discount as mainDiscount, tbl_order_item.discount as subDiscount'))
                    ->where('tbl_order.shop_id',$shop_id)
                    ->whereBetween(DB::raw('date(tbl_order.craeted_date)'),$date)
                    ->orderBy('tbl_order_item.variant_id','asc')
                    ->get();
                    
        $count = $_sel->count();
        
        // dd($_sel);
        foreach($_sel as $key => $sel){
            $netQuantity    = $sel->quantity;
            $gross          = 0;
            $discount       = 0;
            $refunds        = 0;
            $net            = 0;
            $tax            = 0;
            $total          = 0;
            $gross          = $sel->quantity * $sel->item_amount;
            $subVar         = $sel->subVar;
            $subDiscount    = $sel->subDiscount;
            
            if($subVar != 'amount'){
                $subDiscount = $gross * ($subDiscount / 100);
            }
            $mainVar = $sel->mainVar;
            $mainDiscount = $sel->mainDiscount;
            if($mainVar != 'amount'){
                $mainDiscount = ($gross - $subDiscount) * ($mainDiscount / 100);
            }
            $discount = $subDiscount + $mainDiscount;
            if($sel->isTaxExempt == 0 && $sel->hasTax == 1){
                $tax = ($gross - $discount) * ($sel->tax_percentage / 100);
            }
            $net = $gross - $discount;
            $total = $net + $tax;

            if(isset($data['item'][$sel->$columnkey])){
                $netQuantity += $data['item'][$sel->$columnkey]['quantity'];
                $gross += $data['item'][$sel->$columnkey]['gross'];
                $discount += $data['item'][$sel->$columnkey]['discount'];
                $refunds += $data['item'][$sel->$columnkey]['refunds'];
                $net += $data['item'][$sel->$columnkey]['net'];
                $tax += $data['item'][$sel->$columnkey]['tax'];
                $total += $data['item'][$sel->$columnkey]['total'];
            }
            $data['item'][$sel->$columnkey]['quantity'] = $netQuantity;
            $data['item'][$sel->$columnkey]['gross'] = $gross;
            $data['item'][$sel->$columnkey]['discount'] = $discount;
            $data['item'][$sel->$columnkey]['refunds'] = $refunds;
            $data['item'][$sel->$columnkey]['net'] = $net;
            $data['item'][$sel->$columnkey]['tax'] = $tax;
            $data['item'][$sel->$columnkey]['total'] = $total;
            if($sel->variant_name)
            {
                $variant = explode("•",$sel->variant_name);
                $variantStr = '';
                foreach($variant as $var){
                    if($variantStr != ''){
                        $variantStr.='/';
                    }
                    $variantStr.= $var;
                }
                $data['item'][$sel->$columnkey]['variant']  = $variantStr;
            }
            $data['item'][$sel->$columnkey]['info']     = $sel;
            
        }
        if($count == 0){
            // return 'no data';
            return null;
        }
        else{
            return $data;
        }
        //  dd($data);
    }
}