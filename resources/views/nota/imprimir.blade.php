<html>
    <body>
    <style>
    @color-gray: #BCBCBC;
        .text {
            &-center { text-align: center; }
        }
        .ttu { text-transform: uppercase; }

        .printer-ticket {
            display: table !important;
            width: 100%;
            max-width: 400px;
            font-weight: light;
            line-height: 1.3em;
            @printer-padding-base: 10px;
            &, & * { 
                font-family: Tahoma, Geneva, sans-serif; 
                font-size: 10px; 
            }

            th:nth-child(2),
            td:nth-child(2) {
                width: 50px;
            }
            
            th:nth-child(3) ,
            td:nth-child(3) { 
                width: 90px; text-align: right; 
            }
            
            th { 
                font-weight: inherit;
                padding: @printer-padding-base 0;
                text-align: center;
                border-bottom: 1px dashed @color-gray;
            }
            tbody {
                tr:last-child td { padding-bottom: @printer-padding-base; }
            }
            tfoot {
                .sup td {
                    padding: @printer-padding-base 0;
                    border-top: 1px dashed @color-gray;
                }
                .sup.p--0 td { padding-bottom: 0; }
            }
            
            .title { font-size: 1.5em; padding: @printer-padding-base*1.5 0; }
            .top {
                td { padding-top: @printer-padding-base; }
            }
            .last td { padding-bottom: @printer-padding-base; }
        }
    </style>
        <table class="printer-ticket">
        <thead>
            <tr>
                <th class="title" colspan="3"><img src="/img/logo.jpeg" width="100px"/></th>
            </tr>
            <tr>
                <th colspan="3">J|R Grifes Imports</th>
            </tr>
            <tr>
                <th colspan="3">Av Raul Lopes, 880, Teresina-PI</th>
            </tr>
            <tr>
                <th colspan="3">{{date('d/m/Y - h:i:s')}}</th>
            </tr>
            <tr>
                <th colspan="3" align="left">
                    Nome: {{$nota->cliente}} <br />
                    CPF: {{$nota->cpf}}
                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <b>Cupom não fiscal</b>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php $total = 0;?>
            @foreach($products as $product)
                <tr class="top">
                    <td colspan="3"><b>{{$product['nome']}}</b></td>
                </tr>
                <tr class="top">
                    <td colspan="3"><small>{{$product['itemDescription']}}</small></td>
                </tr>
                <tr>
                    <td>R$ {{number_format($product['priceEdit'],2,',','.')}}</td>
                    <td>{{$product['quantidade']}}x</td>
                    <td>R$ {{number_format($product['priceEdit']*$product['quantidade'],2,',','.')}}</td>
                    
                </tr>
                <?php $total += ($product['priceEdit']*$product['quantidade']);?>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="sup ttu p--0">
                <td colspan="3">
                    <b>Totais</b>
                </td>
            </tr>
            <tr class="ttu">
                <td colspan="2">Total</td>
                <td align="right">R$ {{number_format($total,2,',','.')}}</td>
            </tr>
            <tr class="sup">
                <td colspan="3" align="center">
                    <b>Pedido:#{{$nota->id}}</b>
                </td>
            </tr>
            <tr class="sup">
                <td colspan="3" align="center">
                    <b> @jr_grifes_imports <br/>
                <b> (86) 9 94018346</b>
                </td>
            </tr>
        </tfoot>
    </table>
    </body>
</html>
