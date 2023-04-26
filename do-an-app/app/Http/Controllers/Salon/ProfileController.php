<?php

namespace App\Http\Controllers\Salon;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Salon\EditSalonRequest;
use App\Models\Salon;
use App\Repositories\LocationRepository;
use App\Repositories\SalonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;
    /**
     * @var SalonRepository
     */
    private $salonRepository;

    public function __construct(
        SalonRepository $salonRepository,
        LocationRepository $locationRepository
    )
    {
        $this->locationRepository = $locationRepository;
        $this->salonRepository = $salonRepository;
    }

    /** salon **/
    public function validateUpdate(EditSalonRequest $request) {
        return response()->json([
            "success" => true
        ]);
    }

    public function displayProfile() {
        $salon = $this->salonRepository->getSalonById(Auth::guard('salon')->user()->salon_id);
        $provinces =  $this->locationRepository->getAllProvince();

        if($salon) {
            $location = $this->locationRepository->getAddress($salon->ward_code);
            $districts = $this->locationRepository->getByDistrictByProvinceCode($location['province']->code);
            $wards = $this->locationRepository->getByWardByDistrictCode($location['district']->code);

            return view('components.salon.profile.profile',
                compact('salon','provinces','location', 'districts', 'wards'));
        }
    }

    public function update(Request $request) {
        $salon = $this->salonRepository->adminUpdateSalon($request);
        return response()->json([
            "salon" => $salon,
            "success" => true
        ]);
    }

    /** end salon **/

    /** images **/
    public function displayImages() {
        return view('components.salon.profile.image-salon');
    }

    public function loadSalonImage() {
        try {
            $salon = $this->salonRepository->getSalonById(Auth::guard('salon')->user()->salon_id);
            if($salon->images != null || !empty($salon->images)) {
                return json_decode($salon->images);
            return [];
        }
        } catch (\Exception $exception) {
            return [];
        }
    }
    public function imagesSave(Request $request) {
        $idDeletes = json_decode($request->input('deleted_id'), true) ?? [];
        $salon = $this->salonRepository->getSalonById(Auth::guard('salon')->user()->salon_id);
        if(count($idDeletes) > 0) {
            if($salon->images != null || !empty($salon->images)) {
                $newImages = json_decode($salon->images);
                foreach ($newImages as $item) {
                    if (in_array($item->id, $idDeletes)) {
                        ImageHelper::deleteImage('/salon', $item->src);
                    }
                }
            }
        }
        $newImages = [];
        if(isset($request['images'])) {
            foreach ($request['images'] as $image) {
                if(isset($image['file']) && $image['file'] != null) {

                    $originIMG = ImageHelper::saveImage('/salon', $image['file']);
                    $newImages[] = [
                        'id' => $image['id'],
                        'file' => '',
                        'src' => $originIMG
                    ];
                } else {
                    $newImages[] = [
                        'id' => $image['id'],
                        'file' => '',
                        'src' => $image['src']
                    ];
                }
            }
        } else {
            $images = $this->salonRepository
                ->saveImage(json_encode([]), Auth::guard('salon')->user()
                    ->salon_id)->images;

            return response()->json([
                'images' => json_decode($images),
                'success' => true
            ]);
        }
        $images = $this->salonRepository
            ->saveImage(json_encode($newImages), Auth::guard('salon')->user()
                ->salon_id)->images;

        return response()->json([
            'images' => json_decode($images),
            'success' => true
        ]);
    }

    /** end images */

    /** time desc **/
    public function timeDesc() {
        $salon = $this->salonRepository
            ->getSalonById(Auth::guard('salon')->user()->salon_id);

        return view('components.salon.profile.time-desc', compact('salon'));
    }

    public function timeValidate(Request $request) {
        $validated = $request->validate([
            'time_working_desc' => 'required',
            'time_slot_desc' => 'required',
        ], [
            'time_working_desc.required' => 'Trường thời gian là bắt buộc.',
            'time_slot_desc.required' => 'Trường mô tả đoạn thời gian là bắt buộc.',
        ]);

        return response()->json([
           'success' => true
        ]);
    }

    public function timeDescUpdate(Request $request) {
        $idSalon = Auth::guard('salon')->user()->salon_id;
        $salon = $this->salonRepository
            ->updateTimeDesc(
                $idSalon,
                $request->input('time_working_desc'),
                $request->input('time_slot_desc')
            );
        if(!$salon) {
            return response()->json([
                'success' => false
            ]);
        }
        return response()->json([
            'success' => true
        ]);
    }
    /** end time desc */
}
