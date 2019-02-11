<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Snippet\Filter;

use Shopware\Core\Framework\Exception\FilterNotFoundException;

class SnippetFilterFactory implements SnippetFilterFactoryInterface
{
    /**
     * @var array
     */
    private $filters = [];

    public function __construct(iterable $filters)
    {
        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function getFilter(string $name): SnippetFilterInterface
    {
        /** @var SnippetFilterInterface $filter */
        foreach ($this->filters as $filter) {
            if ($filter->supports($name)) {
                return $filter;
            }
        }

        throw new FilterNotFoundException($name, __CLASS__);
    }
}