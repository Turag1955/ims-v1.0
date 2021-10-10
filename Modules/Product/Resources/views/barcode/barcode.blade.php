<div style="width: 100%">
    <button id="print-barcode" type="button" class="text-light btn btn-warning btn-sm float-right"><i class="fas fa-print"></i> Print</button>
     <div id="printableArea" style="width: 100%">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
       @if (!empty($data['product']))
          <table style="width: 100%">
           <?php
               $counter = 0;
               for($i=0; $i < $data['barcode_qty']; $i++ ){
                  if($counter == $data['qty_row']) {
                   ?>
                   <tr>
                       <?php $counter =0;
                  }
                       ?>
                       <td>
                           <div style="text-align:center; width: {{ $data['width'] ? $data['width'] : '38' }}{{ $data['unit'] ? $data['unit'] : 'mm' }}
                           ; height:{{$data['height'] ? $data['height'] : '38'}}{{ $data['unit'] ? $data['unit'] : 'mm' }}; font-size:12px;">
                              
                              <div style="padding-top:20px;font-weight:bold">
                                  {{config('sittings.title')}}
                              </div>
                              @if(!empty($data['name']))
                              <div style="padding-bottom:5px"><p style="margin:0">{{ $data['name']}}</p></div>
                              @endif
                              <div style="width:100%;text-aligh:center">
                                  <img src="{{ 'data:image/png;base64,'. DNS1D::getBarcodePNG($data['product'] , 'C39+') }}" alt="barcode" style="width:100%"/>
                             </div>
                             <div style="letter-spacing:4.2px">{{$data['product']}}</div>
                             @if(!empty($data['price']))
                               <div>
                                   <b>M.R.P:</b>
                                   {{ config('sitings.currency_position') == 'prefix' ? config('sittings.currency_symbol').' '. $data['price'] : $data['price'] .' '. config('sittings.currency_symbol')}}
                               </div>
                             @endif
                          </div>
                       </td>
                       <?php if($counter == 5){?>
                   </tr>
                   <?php
                       $counter = 0;
                       }
                  $counter++;
            }
                 
               
           ?>
           </table>
       @endif
    </div>
</div>