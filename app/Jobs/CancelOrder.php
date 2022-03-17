<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;

use App\Models\Order;
use Carbon\Carbon;
use Http;
use Auth;

class CancelOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order, $user;

    public function middleware()
    {
        return [(new WithoutOverlapping($this->order->id))->dontRelease()];
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->user = $order->user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $xml = '
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:_0="http://idempiere.org/ADInterface/1_0">
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
                        <_0:operation preCommit="false" postCommit="true">
                            <_0:TargetPort>setDocAction</_0:TargetPort>
                            <_0:ModelSetDocAction>
                                <_0:serviceType>docaction_order</_0:serviceType>
                                <_0:recordID>'.$this->order->c_order_id.'</_0:recordID>
                                <_0:docAction>RC</_0:docAction>
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
            $this->order->cancel_message = "Canceled";
            $this->order->is_canceled = 1;
            $this->order->job_id = null;
            $this->order->save();
        }else{
            $error = substr($clean_xml, strpos($clean_xml,'<Error>'), (strpos($clean_xml,'</Error>')-strpos($clean_xml,'<Error>')));
            throw new \Exception($error);
        }
    }
}
