<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\ProvinceModel;
use App\Helpers\ApiFormatter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $city = CityModel::orderBy('city_id', 'ASC')->get();

        $response = ApiFormatter::createJson(
            200,
            'Get Data Success',
            $city
        );

        return response()->json($response);
    }

    public function indexByProvince($province_id)
    {
        try {
            $province = ProvinceModel::find($province_id);

            if (is_null($province)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'Province Not Found'
                    )
                );
            }

            $city = CityModel::where('province_id', $province_id)
                ->orderBy('city_id', 'ASC')
                ->get();

            $response = ApiFormatter::createJson(
                200,
                'Get Data Success',
                $city
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
            $params['code'] = $request->input('code') ?? $request->input('city_code') ?? $params['city_code'] ?? null;
            $params['name'] = $request->input('name') ?? $request->input('city_name') ?? $params['city_name'] ?? null;

            $validator = Validator::make(
                $params,
                [
                    'province_id' => 'required|exists:province,province_id',
                    'code' => 'required|max:10',
                    'name' => 'required',
                ],
                [
                    'province_id.required' => 'Province ID is required',
                    'province_id.exists' => 'Province not found',
                    'code.required' => 'City Code is required',
                    'code.max' => 'City Code must not exceed 10 characters',
                    'name.required' => 'City Name is required',
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

            $city = [
                'province_id' => $params['province_id'],
                'city_code' => $params['code'],
                'city_name' => $params['name'],
            ];

            $data = CityModel::create($city);

            $createdCity = CityModel::find($data->city_id);

            $response = ApiFormatter::createJson(
                200,
                'Create City Success',
                $createdCity
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
            $city = CityModel::find($id);

            if (is_null($city)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'City Not Found'
                    )
                );
            }

            $response = ApiFormatter::createJson(
                200,
                'Get Detail Success',
                $city
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
            $city = CityModel::find($id);

            if (is_null($city)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'City Not Found'
                    )
                );
            }

            $params = $request->all();
            $params['code'] = $request->input('code') ?? $request->input('city_code') ?? $params['city_code'] ?? null;
            $params['name'] = $request->input('name') ?? $request->input('city_name') ?? $params['city_name'] ?? null;

            $validator = Validator::make(
                $params,
                [
                    'province_id' => 'required|exists:province,province_id',
                    'code' => 'required|max:10',
                    'name' => 'required',
                ],
                [
                    'province_id.required' => 'Province ID is required',
                    'province_id.exists' => 'Province not found',
                    'code.required' => 'City Code is required',
                    'code.max' => 'City Code must not exceed 10 characters',
                    'name.required' => 'City Name is required',
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

            $city->update([
                'province_id' => $params['province_id'],
                'city_code' => $params['code'],
                'city_name' => $params['name'],
            ]);

            $updatedCity = CityModel::find($id);

            $response = ApiFormatter::createJson(
                200,
                'Update City Success',
                $updatedCity
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
            $city = CityModel::find($id);

            if (is_null($city)) {
                return response()->json(
                    ApiFormatter::createJson(
                        404,
                        'City Not Found'
                    )
                );
            }

            $city->delete();

            $response = ApiFormatter::createJson(
                200,
                'Delete City Success',
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
