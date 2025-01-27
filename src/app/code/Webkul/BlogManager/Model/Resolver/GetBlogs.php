<?php
namespace Webkul\BlogManager\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webkul\BlogManager\Api\BlogRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class GetBlogs implements ResolverInterface
{
    private $blogRepository;
    private $searchCriteriaBuilder;

    public function __construct(
        BlogRepositoryInterface $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function resolve($field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $searchCriteria = $this->buildSearchCriteria($args);
        $searchResult = $this->blogRepository->getList($searchCriteria);

        $items = [];
        foreach ($searchResult->getItems() as $blog) {
            // Handle raw array data
            $items[] = [
                'EntityId' => is_array($blog) ? $blog['entity_id'] : $blog->getId(),
                'userId' => is_array($blog) ? $blog['user_id'] : $blog->getUserId(),
                'title' => is_array($blog) ? $blog['title'] : $blog->getTitle(),
                'content' => is_array($blog) ? $blog['content'] : $blog->getContent(),
                'status' => is_array($blog) ? $blog['status'] : $blog->getStatus(),
                'createdAt' => is_array($blog) ? $blog['created_at'] : $blog->getCreatedAt(),
                'updatedAt' => is_array($blog) ? $blog['updated_at'] : $blog->getUpdatedAt(),
                'products' => is_array($blog) ? explode(',', $blog['products']) : explode(',', $blog->getProducts()),
            ];
        }

        return [
            'items' => $items,
            'totalCount' => $searchResult->getTotalCount(),
            'page_info' => [
                'currentPage' => $args['currentPage'],
                'pageSize' => $args['pageSize'],
                'totalPages' => ceil($searchResult->getTotalCount() / $args['pageSize']),
            ],
        ];
    }

    private function buildSearchCriteria($args)
    {
        $this->searchCriteriaBuilder->setPageSize($args['pageSize']);
        $this->searchCriteriaBuilder->setCurrentPage($args['currentPage']);
        return $this->searchCriteriaBuilder->create();
    }
}
