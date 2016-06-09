<?php

namespace YallaWebsite\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $BEManager = $this->container->get('backend_manager.manager');
        $hp = $BEManager->getHomepage();
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle('Yalla Night Life Homepage')
                ->addMeta('name', 'description', 'YallaNightLife Homepage')
                ->addMeta('property', 'og:description', 'YallaNightLife Homepage')
                ->addMeta('property', 'twitter:description', 'YallaNightLife Homepage')
                ->addMeta('property', 'og:title', 'Yalla Night Life Homepage')
                ->addMeta('property', 'twitter:title',  'Yalla Night Life Homepage')
                ->addMeta('property', 'og:type', 'website')
                ->addMeta('property', 'og:url',  'http://www.yallanightlife.com/')  
                ->addMeta('property', 'twitter:url',  'http://www.yallanightlife.com/')
                ;
        return $this->render('YallaWebsiteFrontendBundle:Default:index.html.twig', array('home' => $hp));
    }

    public function aboutAction()
    {
        $BEManager = $this->container->get('backend_manager.manager');
        $about = $BEManager->getHomepage()->getAbout();
        $vision = $BEManager->getHomepage()->getVision();
        $members = $this->getDoctrine()->getManager()->getRepository('YallaWebsiteBackendBundle:Member')->findAll();
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle('About - Yalla Night Life')
                ->addMeta('name', 'description', 'YallaNightLife About Page')
                ->addMeta('property', 'og:description', 'YallaNightLife About Page')
                ->addMeta('property', 'twitter:description', 'YallaNightLife About Page')
                ->addMeta('property', 'og:title', 'YallaNightLife About Page')
                ->addMeta('property', 'twitter:title',  'YallaNightLife About Page')
                ->addMeta('property', 'og:type', 'website')
                ->addMeta('property', 'og:url',  'http://www.yallanightlife.com/about')  
                ->addMeta('property', 'twitter:url',  'http://www.yallanightlife.com/about')
                ;
        return $this->render('YallaWebsiteFrontendBundle:Page:about.html.twig', array('about' => $about, 'vision' => $vision, 'members' => $members));
    }

    public function venuesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('YallaWebsiteBackendBundle:Venue');
        $query = $entities->findAll();
        if ($query != NULL) {
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $query, $this->get('request')->query->get('page', 1), 8
            );
        } else {
            $pagination = NULL;
        }
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle('About - Yalla Night Life')
                ->addMeta('name', 'description', 'YallaNightLife Venues Page')
                ->addMeta('property', 'og:description', 'YallaNightLife Venues Page')
                ->addMeta('property', 'twitter:description', 'YallaNightLife Venues Page')
                ->addMeta('property', 'og:title', 'YallaNightLife Venues Page')
                ->addMeta('property', 'twitter:title',  'YallaNightLife Venues Page')
                ->addMeta('property', 'og:type', 'website')
                ->addMeta('property', 'og:url',  'http://www.yallanightlife.com/guides')  
                ->addMeta('property', 'twitter:url',  'http://www.yallanightlife.com/guides');
        return $this->render('YallaWebsiteFrontendBundle:Venue:index.html.twig', array(
                    'pagination' => $pagination
        ));
    }

    public function artistsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('YallaWebsiteBackendBundle:Artist');
        $query = $entities->findAll();
        $upcoming = array();
        foreach ($query as $artist) {
            $events = $em->getRepository('YallaWebsiteBackendBundle:Event')->getUpcomigEventsByArtist($artist);
            if ($events)
                $upcoming[$artist->getId()] = $events;
        }
        if ($query != NULL) {
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $query, $this->get('request')->query->get('page', 1), 8
            );
        } else {
            $pagination = NULL;
        }
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle('Artists - Yalla Night Life')
                ->addMeta('name', 'description', 'YallaNightLife Artists Page')
                ->addMeta('property', 'og:description', 'YallaNightLife Artists Page')
                ->addMeta('property', 'twitter:description', 'YallaNightLife Artists Page')
                
                ->addMeta('property', 'og:title', 'YallaNightLife Artists Page')
                ->addMeta('property', 'twitter:title',  'YallaNightLife Artists Page')
                ->addMeta('property', 'og:type', 'website')
                ->addMeta('property', 'og:url',  'http://www.yallanightlife.com/artists')  
                ->addMeta('property', 'twitter:url',  'http://www.yallanightlife.com/artists');
        return $this->render('YallaWebsiteFrontendBundle:Artist:index.html.twig', array(
                    'pagination' => $pagination,
                    'upcoming' => $upcoming
        ));
    }

    public function articlesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('YallaWebsiteBackendBundle:Article');
        $query = $entities->findAll();
        if ($query != NULL) {
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $query, $this->get('request')->query->get('page', 1), 12
            );
        } else {
            $pagination = NULL;
        }
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle('Gosips - Yalla Night Life')
                ->addMeta('name', 'description', 'YallaNightLife Gossips Page')
                ->addMeta('property', 'og:description', 'YallaNightLife Gossips Page')
                ->addMeta('property', 'twitter:description', 'YallaNightLife Gossips Page')
                ->addMeta('property', 'og:title', 'YallaNightLife Gossips Page')
                ->addMeta('property', 'twitter:title',  'YallaNightLife Gossips Page')
                ->addMeta('property', 'og:type', 'website')
                ->addMeta('property', 'og:url',  'http://www.yallanightlife.com/gossips')  
                ->addMeta('property', 'twitter:url',  'http://www.yallanightlife.com/gossips');
        return $this->render('YallaWebsiteFrontendBundle:Article:index.html.twig', array(
                    'pagination' => $pagination
        ));
    }

    public function getArticleBySlugAction(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            throw $this->createNotFoundException('No Venue Submited to Edit');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('YallaWebsiteBackendBundle:Article')->findBySlug($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find This Venue.');
        }

        return $this->render('YallaWebsiteFrontendBundle:Article:show.html.twig', array(
                    'entity' => $entity,
        ));
    }

    public function eventsAction()
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle('Events - Yalla Night Life')
                ->addMeta('name', 'description', 'YallaNightLife Events Page')
                ->addMeta('property', 'og:description', 'YallaNightLife Events Page')
                ->addMeta('property', 'twitter:description', 'YallaNightLife Events Page')
                ->addMeta('property', 'og:title', 'YallaNightLife Events Page')
                ->addMeta('property', 'twitter:title',  'YallaNightLife Events Page')
                ->addMeta('property', 'og:type', 'website')
                ->addMeta('property', 'og:url',  'http://www.yallanightlife.com/events')  
                ->addMeta('property', 'twitter:url',  'http://www.yallanightlife.com/events');
        return $this->render('YallaWebsiteFrontendBundle:Events:index.html.twig');
    }

    public function getEventBySlugAction(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            throw $this->createNotFoundException('No Venue Submited to Edit');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('YallaWebsiteBackendBundle:Event')->findBySlug($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find This Venue.');
        }
        $seoPage = $this->getSEOData($entity);
        $seoPage
                ->addMeta('property', 'og:url', 'http://www.yallanightlife.com' . $this->generateUrl('yalla_website_frontened_event', array('id' => $entity->getSlug())))
                ->addMeta('property', 'twitter:url', 'http://www.yallanightlife.com' . $this->generateUrl('yalla_website_frontened_event', array('id' => $entity->getSlug())));
        return $this->render('YallaWebsiteFrontendBundle:Events:show.html.twig', array(
                    'entity' => $entity,
        ));
    }

    protected function getSEOData($entity)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage->setTitle($entity->getTitle() . ' - Yalla Night Life')
                ->addMeta('name', 'description', $entity->getMetaDescription())
                ->addMeta('name', 'keywords', $entity->getMetaTags())
                ->addMeta('property', 'og:title', $entity->getTitle() . ' - Yalla Night Life')
                ->addMeta('property', 'og:type', $entity->getOgType())
                ->addMeta('property', 'og:description', $entity->getMetaDescription())
                ->addMeta('property', 'og:image', 'http://www.yallanightlife.com' . $this->getMediaUrl($entity->getMedia()))
                ->addMeta('property', 'twitter:card', $entity->getMetaDescription())
                ->addMeta('property', 'twitter:title', $entity->getTitle() . ' - Yalla Night Life')
                ->addMeta('property', 'twitter:description', $entity->getMetaDescription());
        return $seoPage;
    }

    protected function getMediaUrl($media)
    {
        $provider = $this->container->get($media->getProviderName());
        return $provider->generatePublicUrl($media, 'small');
    }
    
    public function FaceBookRedirectAction(Request $req)
    {
        
        dump($req);EXIT;
    }
    
}