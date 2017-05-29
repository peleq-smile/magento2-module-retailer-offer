<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerOffer
 * @author    Romain Ruaud <romain.ruaud@smile.fr>
 * @copyright 2016 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\RetailerOffer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Smile\Offer\Api\Data\OfferInterfaceFactory as OfferFactory;
use Smile\Offer\Api\OfferRepositoryInterface as OfferRepository;
use Smile\Offer\Model\ResourceModel\Offer\CollectionFactory;
use Smile\RetailerOffer\Controller\Adminhtml\AbstractOffer;


/**
 * Retailer Offer Adminhtml Mass Delete controller.
 *
 * @category  Smile
 * @package   Smile\RetailerOffer
 * @author    Perrine Léquipé <perrine.lequipe@smile.fr>
 */
class MassDelete extends AbstractOffer
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Registry $coreRegistry,
        OfferRepository $offerRepository,
        OfferFactory $offerFactory,
        Filter $filter,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context, $resultPageFactory, $resultForwardFactory, $coreRegistry, $offerRepository, $offerFactory);

        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $offerDeleted = 0;
        foreach ($collection->getItems() as $offer) {
            $offer->delete();
            $offerDeleted++;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $offerDeleted)
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
