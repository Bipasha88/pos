<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
use App\BusinessObjects\CommonList;
 
class CommonListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'offset' => 'required',
                'limit' => 'required',
                'order' => 'required',
                'direction' => 'required',
        ];
    }
 
    public function getObject(){
        $commonlist = new CommonList();
        $commonlist->search = $this->request->get('search');
        $commonlist->offset = $this->request->get('offset');
        $commonlist->limit = $this->request->get('limit');
        $commonlist->order = $this->request->get('order');
        $commonlist->direction = $this->request->get('direction');
        return $commonlist;
    }
}
