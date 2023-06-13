<?php

namespace App\Http\Requests;

use App\Models\Product;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|unique:products,name,' . $this->id,
            'description'=>'nullable|string',
            'price'=>'required|integer|gte:0',
            'slug'=>'required|string|unique:products,slug,' . $this->id
        ];
    }

    protected function prepareForValidation(): void
    {
        $slugify = new Slugify();
        $data = $this->all();

        /**
         * 
         * Update requests don't require all the fields to be given. 
         * E.g: Passing just the id and the price.
         * 
         */
        
        if(isset($this->id)){                                   // On update (not on store)
            $fields = count($data);                             // Counts number of fillable fields filled
            $attr = (new Product)->getFillable();
            if($fields < count($attr)){                         // Checks if any of the fillable fields has not been filled
                $product = Product::find($this->id);            // Retrieves the current product on the DB
                foreach($attr as $field){                       // Loops through every fillable field
                    if(!isset($data[$field])){
                        $data[$field] = $product->$field;       // Any found missing attribute is filled using the current information in the DB
                    }  
                }
            }
        } else {
            $data["slug"] = $slugify->slugify($data["name"]);
        }

        $this->merge($data);
        
    }
}
