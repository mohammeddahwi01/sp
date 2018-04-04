<?php

namespace Eleanorsoft\AddressBook\Block;

use ParadoxLabs\TokenBase\Block\Customer\Cards;

class CreditCards extends Cards
{
    public function getCardsData()
    {
        $cards = $this->getCards();
        $cardData = [];

        foreach ($cards as $card){

            $data['id'] = $card->getId();
            $data['hash'] = $card->getHash();
            $result = array_merge($data, $card->getAddress(), $card->getAdditional());

            $cardData[] = $result;
        }

        return $cardData;
    }

    public function getCardsDataJson()
    {
        return json_encode($this->getCardsData());
    }
}
