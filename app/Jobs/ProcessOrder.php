<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Order;
use Carbon\Carbon;
use Http;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
            <_0:compositeOperation>
                <_0:CompositeRequest>
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
                    <_0:serviceType>composite</_0:serviceType>
                    <_0:operations>
                        <_0:operation preCommit="false" postCommit="false">
                        <_0:TargetPort>createData</_0:TargetPort>
                            <_0:ModelCRUD>
                            <_0:serviceType>create_order</_0:serviceType>
                            <_0:DataRow>
                                <_0:field column="IsSOTrx">
                                    <_0:val>Y</_0:val>
                                </_0:field>
                                <_0:field column="AD_Org_ID">
                                    <_0:val>@#AD_Org_ID</_0:val>
                                </_0:field>
                                <_0:field column="C_Campaign_ID">
                                    <_0:val>1000033</_0:val>
                                </_0:field>
                                <_0:field column="C_DocTypeTarget_ID">
                                    <_0:val>1000437</_0:val>
                                </_0:field>
                                <_0:field column="C_DocType_ID">
                                    <_0:val>1000437</_0:val>
                                </_0:field>
                                <_0:field column="C_BPartner_ID">
                                    <_0:val>1000402</_0:val>
                                </_0:field>
                                <_0:field column="C_BPartner_Location_ID">
                                    <_0:val>1000455</_0:val>
                                </_0:field>
                                <_0:field column="POReference">
                                    <_0:val>'.$this->order->order_no.'</_0:val>
                                </_0:field>
                                <_0:field column="DateOrdered">
                                    <_0:val>'.$this->order->date_ordered.'</_0:val>
                                </_0:field>
                                <_0:field column="DateDelivered">
                                    <_0:val>'.$this->order->date_ordered.'</_0:val>
                                </_0:field>
                                <_0:field column="M_Warehouse_ID">
                                    <_0:val>1000016</_0:val>
                                </_0:field>
                                <_0:field column="M_PriceList_ID">
                                    <_0:val>1000023</_0:val>
                                </_0:field>
                                <_0:field column="SalesRep_ID">
                                    <_0:val>1000064</_0:val>
                                </_0:field>
                            </_0:DataRow>
                            </_0:ModelCRUD>
                        </_0:operation>';

                        foreach($this->order->lines as $line){
                            $xml .= '<_0:operation preCommit="false" postCommit="false">
                            <_0:TargetPort>createData</_0:TargetPort>
                                <_0:ModelCRUD>
                                <_0:serviceType>create_orderline</_0:serviceType>
                                <_0:DataRow>
                                    <_0:field column="C_Order_ID">
                                        <_0:val>@C_Order.C_Order_ID</_0:val>
                                    </_0:field>
                                    <_0:field column="M_Product_ID" lval="'.$line->product_code.'" />
                                    <_0:field column="QtyEntered">
                                        <_0:val>'.$line->quantity.'</_0:val>
                                    </_0:field>
                                    <_0:field column="C_UOM_ID">
                                        <_0:val>1000021</_0:val>
                                    </_0:field>
                                </_0:DataRow>
                                </_0:ModelCRUD>
                            </_0:operation>';
                        }
                        $xml .= '<_0:operation preCommit="false" postCommit="true">
                            <_0:TargetPort>setDocAction</_0:TargetPort>
                            <_0:ModelSetDocAction>
                                <_0:serviceType>docaction_order</_0:serviceType>
                                <_0:recordIDVariable>@C_Order.C_Order_ID</_0:recordIDVariable>
                                <_0:docAction>CO</_0:docAction>
                            </_0:ModelSetDocAction>
                        </_0:operation>
                    </_0:operations>
                </_0:CompositeRequest>
            </_0:compositeOperation>
            </soapenv:Body>
        </soapenv:Envelope>';

        $response = Http::withBody(
            $xml, 'text/xml'
        )->post(config('idempiere.host').'/ADInterface/services/compositeInterface');

        $clean_xml = $response->body();
        $clean_xml = str_ireplace(['NS1:', 'SOAP:'], '', $clean_xml);
        $objXmlDocument = simplexml_load_string($clean_xml);
        $objJsonDocument = json_encode($objXmlDocument);
        $arrOutput = json_decode($objJsonDocument, TRUE);
        if(strpos($clean_xml, 'IsError="true"')==0){
            $results = $arrOutput['Body']['compositeOperationResponse']['CompositeResponses']['CompositeResponse']['StandardResponse'];
            $order = $results[0];
            $order_id = $order['@attributes']['RecordID'];
            $order_no = $order['outputFields']['outputField']['@attributes']['value'];
            $this->order->c_order_id = $order_id;
            $this->order->c_order_no = $order_no;
            $this->order->save();
        }else{
            $error = substr($clean_xml, strpos($clean_xml,'<Error>'), (strpos($clean_xml,'</Error>')-strpos($clean_xml,'<Error>')));
            throw new \Exception($error);
        }
        return "";
    }
}
