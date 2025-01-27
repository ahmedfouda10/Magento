<?php
namespace Webkul\BlogManager\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webkul\BlogManager\Api\BlogRepositoryInterface;

class DeleteBlog implements ResolverInterface
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

        $this->blogRepository->deleteById($args['id']);
        return true;
    }
}
