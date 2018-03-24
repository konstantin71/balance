<?php

namespace app\classes;

use phpQuery;

abstract class Parse
{

    /**
     * Getting DOM object from the contents of the input file
     *
     * @param $content
     * @return \phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     */
    public function getDom($content)
    {
        return phpQuery::newDocumentHTML($content, $charset = 'utf-8');
    }

    /**
     * Abstract a method of parsing a DOM object
     *
     * @param $dom
     * @return mixed
     */
    public abstract function getParse($dom);

    /**
     * Check the minimum number of points required for the balance chart
     *
     * @param $profitTime
     * @return bool
     */
    protected function securityPointCount($profitTime)
    {
        $result = count($profitTime) > 1 ? $profitTime : false;
        return $result;
    }

    /**
     * The calculation of the savings in the follow-up transaction
     *
     * @param $profitTime
     * @return array
     */
    protected function prepareGraph($profitTime)
    {
        $balanceProfit[0] = $profitTime[0]['profit'];
        $balanceTime[0] = $profitTime[0]['time'];
        for ($n = 1; $n < count($profitTime); $n++) {
            $balanceProfit[$n] = $balanceProfit[$n - 1] + $profitTime[$n]['profit'];
            $balanceProfit[$n] = round($balanceProfit[$n], 3);
            $balanceTime[$n] = $profitTime[$n]['time'];
        }
        $balance = [
            'profit' => $balanceProfit,
            'time' => $balanceTime,
        ];
        return $balance;
    }

}