<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\GiveawaySubmission;
use Livewire\Component;

class GiveawayForm extends Component
{
    public string $fullName = '';
    public string $email = '';
    public string $phone = '';
    public string $carModel = '';
    public string $street = '';
    public string $city = '';
    public string $zip = '';
    public string $country = '';
    public bool $submitted = false;
    public ?GiveawaySubmission $lastSubmission = null;

    public function mount($car = null)
    {
        $models = $this->getModels();
        $firstKey = array_key_first($models) ?: 'model_3';

        $this->carModel = ($car && array_key_exists($car, $models)) ? $car : $firstKey;
    }

    protected function getModels(): array
    {
        return Car::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(fn (Car $car) => [
                $car->key => [
                    'name' => $car->name,
                    'desc' => $car->desc,
                    'fee' => $car->fee,
                    'image' => $car->image,
                ],
            ])
            ->toArray();
    }

    public function getRules(): array
    {
        $keys = implode(',', array_keys($this->getModels()));

        return [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'carModel' => 'required|string|in:' . $keys,
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|size:2',
        ];
    }

    public function updated($property)
    {
        $this->validateOnly($property, $this->getRules());
    }

    public function submit()
    {
        $this->validate($this->getRules());

        $existingPending = GiveawaySubmission::where('email', $this->email)
            ->where('payment_status', 'pending')
            ->exists();

        if ($existingPending) {
            $this->addError('email', 'You already have a submission awaiting payment confirmation. Please wait for admin approval.');
            return;
        }

        $models = $this->getModels();
        $car = $models[$this->carModel] ?? reset($models);

        $submission = GiveawaySubmission::create([
            'full_name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'car_model' => $this->carModel,
            'car_name' => $car['name'],
            'car_fee' => $car['fee'],
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'country' => $this->country,
        ]);

        session()->put('payment_submission_id', $submission->id);

        return $this->redirectRoute('payment');
    }

    public function render()
    {
        $models = $this->getModels();
        $car = $models[$this->carModel] ?? reset($models);

        return view('livewire.giveaway-form', [
            'models' => $models,
            'selectedCar' => $car,
        ]);
    }
}
