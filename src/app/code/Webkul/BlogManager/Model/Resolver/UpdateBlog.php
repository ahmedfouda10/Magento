<?php
namespace Webkul\BlogManager\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webkul\BlogManager\Api\BlogRepositoryInterface;

class UpdateBlog implements ResolverInterface
{
    private $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['id'])) {
            throw new \Exception('Id is required');
        }

        $input = $args['input'];
        $blog = $this->blogRepository->getById($args['id']);

        $blog->setTitle($input['title']);
        $blog->setContent($input['content']);
        $blog->setStatus($input['status']);
        $blog->setUserId($input['userId']);
        $blog->setProducts(implode(',', $input['products']));
        $blog->setUpdatedAt(date('Y-m-d H:i:s'));

        $this->blogRepository->save($blog);

        return [
            'id' => $blog->getId(),
            'userId' => $blog->getUserId(),
            'title' => $blog->getTitle(),
            'content' => $blog->getContent(),
            'status' => $blog->getStatus(),
            'createdAt' => $blog->getCreatedAt(),
            'updatedAt' => $blog->getUpdatedAt(),
            'products' => explode(',', $blog->getProducts()),
        ];
    }
}
