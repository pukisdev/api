<?php

namespace App\Http\Controllers\PMS;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\pms_customer_mst as modelMst;

// use App\Http\Requests\reqPmsCustomerMst as reqMst;
use Carbon\Carbon as Carbon;
use DB;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('search')){
            $items = modelMst::where('sys_status_aktif','A')->where("nama_customer", "LIKE", "%".$request->get('search')."%")->paginate(5);      
        }else{
          $items = modelMst::where('sys_status_aktif','A')->paginate(5);
        }
        // dd($items);
        return response($items);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(reqMst $request, modelMst $model)
    public function store(Request $request, modelMst $model)
    {
         $request->merge(array(
            'id_customer' => $this->generate_id(),
            'sys_user_update' => 'ADMIN',
        ));
         // dd($request->all());   

        $model->create($request->all());
        return $model->find($request->id_customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return modelMst::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */ 
    // public function update(reqMst $request, modelMst $customer)
    public function update(Request $request, modelMst $customer)
    {
        // DB::enableQueryLog();    

        // // dd($request->all());
        // // $abc->fill($request->all())->save();
        // // return response($abc->find($id));
        // // return response($abc->find($request->id_customer));
        $update = $customer->find($request->id_customer);
        $update->nama_customer    = $request->nama_customer;
        $update->sys_user_update  = $request->sys_user_update;
        $update->sys_status_aktif = $request->sys_status_aktif;
        $update->sys_tgl_update = Carbon::now();
        $update->save();
        // dd(DB::getQueryLog());   

        return response($customer->find($request->id_customer));
        // return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        modelMst::where((new modelMst)->getKeyName(), $id)->update(['sys_status_aktif'=>'N']);        
    }

    /**
     * @function generate_id dibuat dan dikembangkan oleh rianday.
     * @depok
     * @return id
     */
    private function generate_id(){
        $max_id = modelMst::where('id_customer','like','CST-%')->max('id_customer');
        return 'CST-'.(!empty($max_id) ? str_pad(((int)substr($max_id, strpos($max_id,'-')+1)+1),5,'0',STR_PAD_LEFT) : '00001'); 
    }

}
