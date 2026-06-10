<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DistrictModel;
use App\Models\CityModel;
use App\Helpers\ApiFormatter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $district = DistrictModel::orderBy('district_id', 'ASC')->get();

        $response = ApiFormatter::createJson(
            200,
            'Get Data Success',
            $district
        );

        return response()->json($response);
    }

    public function indexByCity($city_id)
    {
        try {
            $city = CityModel::find($city_id);

            if (is_null($city)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'City Not Found'
                    )
                );
            }

            $district = DistrictModel::where('city_id', $city_id)
                ->orderBy('district_id', 'ASC')
                ->get();

            $response = ApiFormatter::createJson(
                200,
                'Get Data Success',
                $district
            );

            return response()->json($response);

        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(
                500,
                'Internal Server Error',
                $e->getMessage()
            );

            return response()->json($response);
        }
    }

    public function create(Request $request)
    {
        try {
            $params = $request->all();

            $validator = Validator::make(
                $params,
                [
                    'city_id' => 'required|exists:city,city_id',
                    'code' => 'required|max:10',
                    'name' => 'required',
                ],
                [
                    'city_id.required' => 'City ID is required',
                    'city_id.exists' => 'City not found',
                    'code.required' => 'District Code is required',
                    'code.max' => 'District Code must not exceed 10 characters',
                    'name.required' => 'District Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(
                    400,
                    'Bad Request',
                    $validator->errors()->all()
                );

                return response()->json($response);
            }

            $district = [
                'city_id' => $params['city_id'],
                'district_code' => $params['code'],
                'district_name' => $params['name'],
            ];

            $data = DistrictModel::create($district);

            $createdDistrict = DistrictModel::find($data->district_id);

            $response = ApiFormatter::createJson(
                200,
                'Create District Success',
                $createdDistrict
            );

            return response()->json($response);

        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(
                500,
                'Internal Server Error',
                $e->getMessage()
            );

            return response()->json($response);
        }
    }

    public function detail($id)
    {
        try {
            $district = DistrictModel::find($id);

            if (is_null($district)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'District Not Found'
                    )
                );
            }

            $response = ApiFormatter::createJson(
                200,
                'Get Detail Success',
                $district
            );

            return response()->json($response);

        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(
                500,
                'Internal Server Error',
                $e->getMessage()
            );

            return response()->json($response);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $district = DistrictModel::find($id);

            if (is_null($district)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'District Not Found'
                    )
                );
            }

            $params = $request->all();

            $validator = Validator::make(
                $params,
                [
                    'city_id' => 'required|exists:city,city_id',
                    'code' => 'required|max:10',
                    'name' => 'required',
                ],
                [
                    'city_id.required' => 'City ID is required',
                    'city_id.exists' => 'City not found',
                    'code.required' => 'District Code is required',
                    'code.max' => 'District Code must not exceed 10 characters',
                    'name.required' => 'District Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(
                    400,
                    'Bad Request',
                    $validator->errors()->all()
                );

                return response()->json($response);
            }

            $district->update([
                'city_id' => $params['city_id'],
                'district_code' => $params['code'],
                'district_name' => $params['name'],
            ]);

            $updatedDistrict = DistrictModel::find($id);

            $response = ApiFormatter::createJson(
                200,
                'Update District Success',
                $updatedDistrict
            );

            return response()->json($response);

        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(
                500,
                'Internal Server Error',
                $e->getMessage()
            );

            return response()->json($response);
        }
    }

    public function patch($id, Request $request)
    {
        return $this->update($id, $request);
    }

    public function delete($id)
    {
        try {
            $district = DistrictModel::find($id);

            if (is_null($district)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'District Not Found'
                    )
                );
            }

            $district->delete();

            $response = ApiFormatter::createJson(
                200,
                'Delete District Success',
                []
            );

            return response()->json($response);

        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(
                500,
                'Internal Server Error',
                $e->getMessage()
            );

            return response()->json($response);
        }
    }
}
