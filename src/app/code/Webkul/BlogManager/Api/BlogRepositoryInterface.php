<?php
namespace Webkul\BlogManager\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Webkul\BlogManager\Api\Data\BlogInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;


/**
 * Interface BlogRepositoryInterface
 *
 * @api
 */
interface BlogRepositoryInterface
{
    /**
     * Get Blog List
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve a blog post by its ID.
     *
     * @param int $id
     * @return BlogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If blog with specified ID does not exist.
     */
    public function getById($id): BlogInterface;

    /**
     * Save a blog post.
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException If there was an error saving the blog.
     */
    public function save(BlogInterface $blog): BlogInterface;


/**
     * Delete Blog by ID.
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($id);
}
