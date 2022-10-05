<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class TrxLog extends Plugin
{
    public function sidebar()
    {
        $logBank = Item::create(__('Log Bank'))
            ->route('trxLog.bank')
            ->active("log-transaction/bank");

        $logSIPD = Item::create(__('Log SIPD'))
            ->route('trxLog.sipd')
            ->active("log-transaction/sipd");

        return Item::create(__('Transaction Log'))
            ->href('#trxLog-dropdown')
            ->icon('fas fa-history')
            ->addChildren([
                $logBank,
                $logSIPD
            ])->permissions("transaction-log");
    }
}
