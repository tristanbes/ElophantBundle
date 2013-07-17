<?php

namespace Tristanbes\ElophantBundle\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

class ApiDashboardBlock extends BaseBlockService
{
    private $entityManager;
    private $maxDisplayedDays;

    public function setEntityManager(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getMaxDisplayedDays()
    {
        return $this->maxDisplayedDays;
    }

    public function setMaxDisplayedDays($days)
    {
        $this->maxDisplayedDays = $days;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        $repository = $this->getEntityManager()->getRepository("TristanbesElophantBundle:ApiCall");

        $results = $repository->getStatsPerDay($this->getMaxDisplayedDays());

        return $this->renderResponse($blockContext->getTemplate(), array(
            'results'  => $results,
            'block'    => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'title'    => 'Elophant Api Statistics',
            'template' => 'TristanbesElophantBundle:Block:statistics.html.twig',
        ));
    }

    /**
     * @param FormMapper     $form
     * @param BlockInterface $block
     *
     * @return void
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {

    }

    /**
     * @param ErrorElement   $errorElement
     * @param BlockInterface $block
     *
     * @return void
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return "sonata_block_api_elophant";
    }


    /**
     * @param $media
     *
     * @return array
     */
    public function getJavascripts($media)
    {
        return array(
            '/bundles/tristanbeselophant/js/highcharts.js',
            '/bundles/tristanbeselophant/js/highcharts-more.js'
        );
    }

    /**
     * @param $media
     *
     * @return array
     */
    public function getStylesheets($media)
    {
        return array();
    }

    /**
     * @param BlockInterface $block
     *
     * @return array
     */
    public function getCacheKeys(BlockInterface $block)
    {
        return array();
    }

}
