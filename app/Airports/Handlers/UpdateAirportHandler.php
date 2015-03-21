<?php namespace Zbw\Airports\Handlers;

use Zbw\Airports\Commands\UpdateAirportCommand;
use Zbw\Airports\Contracts\AirportRepository;
use Zbw\Core\BaseCommandResponse;

class UpdateAirportHandler
{
    private $airports;

    public function __construct(AirportRepository $airports)
    {
        $this->airports = $airports;
    }

    public function handle(UpdateAirportCommand $command)
    {
        $this->response = new BaseCommandResponse();

        return $this->airportIsInvalid($command) ?: $this->updateAirport($command);
    }

    private function airportIsInvalid($command)
    {
        if(! $command->icao->isValid()) {
            $this->response->setFlashData(['flash_error' => 'Invalid ICAO code']);
            return $this->response;
        }

        return false;
    }

    private function updateAirport($command)
    {
        $airport = $this->airports->getByIcao($command->icao->icao());
        if(! $airport) {
            $this->response->setFlashData(['flash_error' => $command->icao->icao() . ' not found']);
            return $this->response;
        }
        $airport->fill($command->data);
        if($this->airports->save($airport)) {
            $this->response->setFlashData(['flash_success' => $airport->icao . ' updated successfully']);
        } else {
            $this->response->setFlashData(['flash_error' => 'Unable to update' . $airport->icao]);
        }

        return $this->response;
    }
}
