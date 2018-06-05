<?php

namespace AdrianBaez\DataManager\Tests\Pager;

use PHPUnit\Framework\TestCase;
use AdrianBaez\DataManager\Pager\ArrayPager;

class ArrayPagerTest extends TestCase
{
    /**
     * @dataProvider getPager
     */
    public function testGetIterator(array $data, int $page, int $maxPerPage, int $lastPage, array $inPage)
    {
        $pager = new ArrayPager($data);
        $pager->setPage($page)
            ->setMaxPerPage($maxPerPage)
            ->initialize();

        $this->assertEquals($inPage, iterator_to_array($pager));

        $this->assertCount(count($data), $pager);
        $this->assertSame($lastPage, $pager->getLastPage());
    }

    public function getPager()
    {
        $data = range(1, 10);
        // data, page, maxPerPage, lastPage, inPage
        yield [$data, 0, 0, 0, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];
        yield [$data, 1, 3, 4, [1, 2, 3]];
        yield [$data, 4, 3, 4, [10]];
        yield [$data, 2, 4, 3, [5, 6, 7, 8]];
    }
}
