<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Product;
use Carbon\Carbon;
use Http;

class GetProducts
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:_0="http://idempiere.org/ADInterface/1_0">
        <soapenv:Header/>
        <soapenv:Body>
            <_0:queryData>
                <_0:ModelCRUDRequest>
                    <_0:ModelCRUD>
                        <_0:serviceType>get_products</_0:serviceType>
                        <_0:DataRow>
                        <_0:field column="M_PriceList_ID">
                            <_0:val>'.config('idempiere.pricelist').'</_0:val>
                        </_0:field>
                    </_0:DataRow>
                    </_0:ModelCRUD>
                    <_0:ADLoginRequest>
                        <_0:user>'.config('idempiere.user').'</_0:user>
                        <_0:pass>'.config('idempiere.pass').'</_0:pass>
                        <_0:lang>EN</_0:lang>
                        <_0:ClientID>'.config('idempiere.client').'</_0:ClientID>
                        <_0:RoleID>'.config('idempiere.role').'</_0:RoleID>
                        <_0:OrgID>'.config('idempiere.organization').'</_0:OrgID>
                        <_0:WarehouseID>'.config('idempiere.warehouse').'</_0:WarehouseID>
                        <_0:stage>0</_0:stage>
                    </_0:ADLoginRequest>
                </_0:ModelCRUDRequest>
            </_0:queryData>
        </soapenv:Body>
    </soapenv:Envelope>';

        $response = Http::withBody(
            $xml, 'text/xml'
        )->post(config('idempiere.host').'/ADInterface/services/ModelADService');

        $clean_xml = $response->body();
        $clean_xml = str_ireplace(['NS1:', 'SOAP:'], '', $clean_xml);
        $objXmlDocument = simplexml_load_string($clean_xml);
        $objJsonDocument = json_encode($objXmlDocument);
        $arrOutput = json_decode($objJsonDocument, TRUE);
        if(strpos($clean_xml, 'IsError="true"')==0){
            Product::truncate();
            $rows = $arrOutput['Body']['queryDataResponse']['WindowTabData']['DataSet']['DataRow'];
            foreach($rows as $row){
                $data = [];
                foreach($row['field'] as $field){
                    $column = strtolower($field['@attributes']['column']);
                    if($column=='isactive'){
                        $data['is_active'] = $field['val']=='Y';
                    }elseif($column=='pricelist'){
                        $data['price'] = $field['val'];
                    }else{
                        $data[$column] = $field['val'];
                    }
                }
                $product = Product::where('value',$data['value'])->first();
                if($product==null){
                    Product::create($data);
                }else
                    $Product->update($data);
            }
        }else{
            $error = substr($clean_xml, strpos($clean_xml,'<Error>'), (strpos($clean_xml,'</Error>')-strpos($clean_xml,'<Error>')));
            throw new \Exception($error);
        }
        return "";
    }
}
