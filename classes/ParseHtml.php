<?php


namespace app\classes;


class ParseHtml extends Parse
{

    /**
     * Parsing the column "profit" from the DOM object of HTML document
     *
     * @param $dom
     * @return bool|mixed|string
     */
    public function getParse($dom)
    {
        $lines = $dom->find('tr');
        if ($lines) {
            $n = 0;
            foreach ($lines as $line) {
                $lineSelect = pq($line);
                $openTime = $lineSelect->find('.msdate:first')->text();
                if ($openTime) {
                  //  $profit = $lineSelect->find('td:last')->text();
                    $profit = preg_replace('/\s+/', '', ($lineSelect->find('td:last')->text()));
                    if (is_numeric($profit)) {
                        $profitTime[$n]['profit'] = $profit;
                        $profitTime[$n]['time'] = $openTime;
                        $n++;
                    }
                }
            }
            $result = isset($profitTime) ? $this->securityPointCount($profitTime) : false;
        } else $result = false;
        return $result ? $this->prepareGraph($result) : $result;
    }

}