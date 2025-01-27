<?php
namespace Webkul\BlogManager\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webkul\BlogManager\Api\BlogRepositoryInterface;

class CreateBlog implements ResolverInterface
{
    private $blogRepository;
    private $blogFactory;

    public function __construct(BlogRepositoryInterface $blogRepository , \Webkul\BlogManager\Model\BlogFactory $blogFactory,)
    {
        $this->blogRepository = $blogRepository;
        $this->blogFactory = $blogFactory;
    }

    public function resolve($field,$context,ResolveInfo $info,array $value = null,array $args = null) {
        $input = $args['input'];
        // Create a new blog object
        $blog = $this->blogFactory->create();
        $blog->setTitle($input['title']);
        $blog->setContent($input['content']);
        $blog->setStatus($input['status']);
        $blog->setUserId($input['userId']);
        $blog->setProducts(implode(',', $input['products']));
        $blog->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
        $blog->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));
        $blog = $this->blogRepository->save($blog);

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
    }
}
