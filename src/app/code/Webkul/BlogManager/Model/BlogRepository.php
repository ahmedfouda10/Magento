<?php
namespace Webkul\BlogManager\Model;

use Webkul\BlogManager\Api\BlogRepositoryInterface;
use Webkul\BlogManager\Api\Data\BlogInterface;
use Webkul\BlogManager\Model\ResourceModel\Blog as BlogResource;
use Webkul\BlogManager\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Psr\Log\LoggerInterface;
/**
 * Class BlogRepository
 *
 * @package Webkul\BlogManager\Model
 */
class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var BlogResource
     */
    protected $blogResource;
    protected $logger;
    /**
     * @var \Webkul\BlogManager\Model\BlogFactory
     */
    protected $blogFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param BlogResource $blogResource
     * @param \Webkul\BlogManager\Model\BlogFactory $blogFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        BlogResource $blogResource,
        \Webkul\BlogManager\Model\BlogFactory $blogFactory,
        LoggerInterface $logger

    ) {
        $this->collectionFactory = $collectionFactory;
        $this->blogResource = $blogResource;
        $this->blogFactory = $blogFactory;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        // تطبيق الفلاتر من معايير البحث
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $collection->addFieldToFilter(
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
            }
        }

        // إعداد الترقيم
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());

        // إنشاء نتائج البحث
        /** @var SearchResultsInterface $searchResults */
        $searchResults = new SearchResults();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getData());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id): BlogInterface
    {
        $this->logger->info('Received ID: ' . $id); // Add logging
        $blog = $this->blogFactory->create();
        $this->blogResource->load($blog, $id);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Blog with ID "%1" does not exist.', $id));
        }
        // dd($blog);
        return $blog;
    }


    /**
     * {@inheritdoc}
     */
    public function save(BlogInterface $blog): BlogInterface
    {
        $this->logger->info('Incoming blog data: ' . print_r($blog->getData(), true));
        try {

            if($blog->getId()){
                $model=$this->blogFactory->create()->load($blog->getId());
                $model->setTitle($blog->getTitle());
                $model->setContent($blog->getContent());
                $model->setStatus($blog->getStatus());
                if (isset($data['products'])) {
                    $model->setProducts(implode(',', $blog->getProducts()));
                } else {
                    $model->setProducts('');
                }
                $model->save();
            }else{

                // Set default timestamps if not provided
                if (!$blog->getCreatedAt()) {
                    $blog->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                }
                $blog->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));

                $this->blogResource->save($blog);
            }
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save the blog: %1', $e->getMessage()));
        }
        return $blog;
    }


/**
     * Delete Blog by ID.
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        $blog = $this->blogFactory->create();
        $this->blogResource->load($blog, $id);

        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Blog with ID %1 does not exist.', $id));
        }

        $this->blogResource->delete($blog);
        return true;
    }
}
