<?php
namespace Webkul\BlogManager\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Webkul\BlogManager\Api\BlogRepositoryInterface;

class GetBlog implements ResolverInterface
{
    private $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function resolve($field,$context,ResolveInfo $info,array $value = null,array $args = null) {
        if (!isset($args['EntityId'])) {
            throw new \Exception('Id is required');
        }

        try {
            $blog = $this->blogRepository->getById($args['EntityId']);
            return [
                'EntityId' => $blog->getId(),
                'userId' => $blog->getUserId(),
                'title' => $blog->getTitle(),
                'content' => $blog->getContent(),
                'status' => $blog->getStatus(),
                'createdAt' => $blog->getCreatedAt(),
                'updatedAt' => $blog->getUpdatedAt(),
                'products' => explode(',', $blog->getProducts()),
            ];
        } catch (NoSuchEntityException $e) {
            throw new \Exception('Blog not found');
        }
    }
}
