<div class="report-container">
    <div class="panel panel-default panel-block panel-title-block panel-report load-data">
        <div class="panel-heading load-content">
        @include('member.reports.report_header')
        <div class="table-reponsive">
            <table class="table table-condensed  collaptable">
                <thead>
                    <tr>
                        <th colspan="5"></th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $income         = 0;
                        $cog            = 0;
                        $expense        = 0;
                        $other_income   = 0;
                        $other_expense  = 0;
                    ?>
                    @foreach($_account as $key=>$account)
                        <tr data-id="type-{{$account->chart_type_id}}" data-parent="">
                            <td colspan="2" >{{strtoupper($account->chart_type_name)}}</td>
                            <td colspan="3"></td>
                            <td class="text-right"><text class="total-report">{{currency('PHP', collect($account->account_details)->sum('amount'))}}</text></td>
                        </tr>
                        @foreach($account->account_details as $key1=>$acc_details)
                            <tr data-id="account-{{$key1}}" data-parent="type-{{$account->chart_type_id}}">
                                <td></td>
                                <td>{{$acc_details->account_name}}</td>
                                <td colspan="3"></td>
                                <td class="text-right">{{currency('PHP', $acc_details->amount)}}</td>
                            </tr>
                        @endforeach
                        
                        @if(count($account->account_details) > 0)
                            <tr data-id="account-{{$account->chart_type_id}}" data-parent="type-{{$account->chart_type_id}}">
                                <td></td>
                                <td>Total</td>
                                <td colspan="3"></td>
                                <td class="text-right">{{currency('PHP', collect($account->account_details)->sum('amount'))}}</td>
                            </tr>
                        @endif

                        @if($account->chart_type_name == "Income")
                            <?php $income = collect($account->account_details)->sum('amount'); ?>
                        @elseif($account->chart_type_name == "Other Income")
                            <?php $other_income = collect($account->account_details)->sum('amount'); ?>
                        @endif


                        @if($account->chart_type_name == "Cost of Goods Sold")
                            <?php $cog = collect($account->account_details)->sum('amount'); ?>
                            <tr>
                                <td colspan="5" >GROSS PROFIT</td>
                                <td class="text-right">{{currency('PHP', $income - $cog)}}</td>
                            </tr>
                        @elseif($account->chart_type_name == "Expense")
                            <?php $expense = collect($account->account_details)->sum('amount'); ?>
                            <tr>
                                <td colspan="5" >NET OPERATING INCOME</td>
                                <td class="text-right">{{currency('PHP', ($income - $cog) - $expense)}}</td>
                            </tr>
                        @elseif($account->chart_type_name == "Other Expense")
                            <?php $other_expense = collect($account->account_details)->sum('amount'); ?>
                            <tr>
                                <td colspan="5" >NET OTHER INCOME</td>
                                <td class="text-right">{{currency('PHP', $other_income - $other_expense)}}</td>
                            </tr>
                            <tr>
                                <td colspan="5" >NET INCOME</td>
                                <td class="text-right"><b>{{currency('PHP', (($income - $cog) - $expense) - ($other_income - $other_expense))}}<b></td>
                            </tr>
                        @endif

                    @endforeach
                </tbody>
            </table>
        </div>
        <h5 class="text-center">---- {{$now or ''}} ----</h5>
        </div>
    </div>
</div>