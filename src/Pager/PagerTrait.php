<?php

namespace AdrianBaez\DataManager\Pager;

trait PagerTrait
{
    private $page = 1;
    private $maxPerPage = 0;
    private $lastPage = 1;
    private $nbResults = 0;

    abstract public function initialize();

    abstract public function getIterator();

    public function setPage(int $page): self
    {
        $this->page = intval($page);

        if ($this->page <= 0) {
            $this->page = $this->maxPerPage ? 1 : 0;
        }

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setMaxPerPage(int $maxPerPage): self
    {
        if ($maxPerPage > 0) {
            $this->maxPerPage = $maxPerPage;

            if ($this->page == 0) {
                $this->page = 1;
            }
        } elseif ($maxPerPage == 0) {
            $this->maxPerPage = 0;
            $this->page = 0;
        } else {
            $this->maxPerPage = 1;

            if ($this->page == 0) {
                $this->page = 1;
            }
        }
        return $this;
    }

    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    public function getNbResults(): int
    {
        return $this->nbResults;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function count()
    {
        return $this->nbResults;
    }

    protected function setLastPage($lastPage): self
    {
        $this->lastPage = $lastPage;

        if ($this->page > $lastPage) {
            $this->setPage($lastPage);
        }

        return $this;
    }

    protected function setNbResults(int $nbResults): self
    {
        $this->nbResults = $nbResults;

        if ($this->page === 0 || $this->maxPerPage === 0) {
            $this->setLastPage(0);
        } else {
            $this->setLastPage(ceil($this->nbResults / $this->maxPerPage));
        }

        return $this;
    }
}
