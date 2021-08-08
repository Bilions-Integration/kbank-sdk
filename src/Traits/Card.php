<?php

namespace Bilions\Traits;

trait Card {
  /**
   * get redirect url for card or aliPay
   */
  private function getRedirectUrlForCard() {
    try {
      $params = [
        'callback_type'   => 'web',
        'amount'          => $this->amount,
        'currency'        => $this->currency,
        'description'     => $this->description,
        'source_type'     => $this->paymentType,
        'reference_order' => $this->referenceOrder,
        'ref_1'           => $this->ref1 ?? null,
        'ref_2'           => $this->ref2 ?? null,
        'additional_data' => [
          'mid' => $this->config['KBANK_MID'],
          'tid' => $this->config['KBANK_TID'],
        ],
        'token'           => $this->token,
        'mode'            => 'token',
      ];
      if ($this->dccCurrency) {
        $params['dcc_data'] = ['dcc_currency' => $this->dccCurrency];
      }
      return $this->send('POST', '/card/v2/charge', $params);
    } catch (Exception $e) {
      throw $e;
    }
  }
}
