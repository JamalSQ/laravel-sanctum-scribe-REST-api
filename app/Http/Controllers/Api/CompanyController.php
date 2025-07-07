<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\CompanyModel;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use PhpParser\Node\Stmt\TryCatch;

class CompanyController extends Controller
{
    /**
     * Display the list of companies.
     *
     * This endpoint returns all registered companies.
     *
     * @group Companies
     * @response 200 {
     *   "result": [
     *     {
     *       "id": 1,
     *       "name": "Company A",
     *       "email": "companya@example.com",
     *       "address": "123 Street",
     *       "phoneNo": "12345678901"
     *     }
     *   ],
     *   "message": "Records retrieved successfully"
     * }
     */
    public function index(): JsonResponse
    {
        $CompaniesData = CompanyModel::latest()->get();

        return response()->json([
            'result' => $CompaniesData,
            'message' => 'Records reterieved successfully'
        ], 200);
    }

    /**
     * Store a new company.
     *
     * Creates a new company record with the provided data.
     *
     * @group Companies
     * @bodyParam name string required Max 500 characters.
     * @bodyParam email string required Unique email address.
     * @bodyParam address string required Max 500 characters.
     * @bodyParam phoneNo string required Exactly 11 digits.
     *
     * @response 201 {
     *   "message": "Company created successfully",
     *   "result": {
     *     "id": 1,
     *     "name": "Bob",
     *     "email": "bob@gmail.com",
     *     "address": "One Unit chock",
     *     "phoneNo": "34223423429"
     *   }
     * }
     *
     * @response 422 {
     *   "message": "Unable to create Company",
     *   "errors": {
     *     "email": ["The email has already been taken."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
       
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:500',
            'email'=>'required|email|unique:companies,email',
            'address'=>'required|string|max:500',
            'phoneNo'=>'required|digits:11'

        ]);
    
        if($validator->fails()){

             return response()->json([
                'message' => 'Unable to create Company',
                'errors' => $validator->messages(),
            ], 422);

        }else{
             $Companies = CompanyModel::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'address'=>$request->address,
                'phoneNo'=>$request->phoneNo
            ]);

            return response()->json([
                'message' => "Company created successfully",
                'result' => new CompanyResource($Companies),
            ], 200);

        }    
    }

    /**
     * Display a specific company.
     *
     * @group Companies
     * @urlParam company integer required The ID of the company.
     *
     * @response 200 {
     *   "message": "Company retrieved successfully",
     *   "result": {
     *     "id": 1,
     *     "name": "Company A",
     *     "email": "companya@example.com",
     *     "address": "123 Street",
     *     "phoneNo": "12345678901"
     *   }
     * }
     *
     * @response 404 {
     *   "error": "Company not found"
     * }
     */
    public function show(CompanyModel $company): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Company retrieved successfully',
                'result' => new CompanyResource($company),
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'Error' => 'Unable to show Company record',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a specific company.
     *
     * @group Companies
     * @urlParam company integer required The ID of the company.
     * @bodyParam name string Max 500 characters.
     * @bodyParam email string Unique email address.
     * @bodyParam address string Max 500 characters.
     * @bodyParam phoneNo string Exactly 11 digits.
     *
     * @response 200 {
     *   "message": "Company updated successfully",
     *   "result": {
     *     "id": 1,
     *     "name": "Updated Company",
     *     "email": "updated@example.com",
     *     "address": "Updated Address",
     *     "phoneNo": "12345678901"
     *   }
     * }
     *
     * @response 422 {
     *   "error": "Failed to update company",
     *   "details": "Validation failed or other error messages"
     * }
     *
     * @response 404 {
     *   "error": "Company not found"
     * }
     */
    public function update(CompanyModel $company, ValidateCompanyRequest $request): JsonResponse
    {

        try {
            $company->update($request->validated());

            return response()->json([
                'message' => 'Company updated successfully',
                'result' => new CompanyResource($company),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update company',
                'details' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete a specific company.
     *
     * @group Companies
     * @urlParam company integer required The ID of the company.
     *
     * @response 200 {
     *   "message": "Company deleted successfully"
     * }
     *
     * @response 404 {
     *   "error": "Company not found"
     * }
     *
     * @response 500 {
     *   "error": "Failed to delete company",
     *   "details": "Exception message"
     * }
     */
    public function destroy(CompanyModel $company): JsonResponse
    {
        try {
            $company->delete();

            return response()->json([
                'message' => 'Company deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to delete company',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
