Installation
============

Add tristanbes/elophant-bundle to composer.json
-----------------------------

::

    "require": {
        ...
        "tristanbes/elophant-bundle": "1.0.*",
        ...
    }
    
As the bundle will install for the cache mechanism snc/redis-bundle, make sure that you've correctly configured it. See the snc/redis-bundle [documentation](https://github.com/snc/SncRedisBundle/blob/master/Resources/doc/index.md)

Add TristanbesElophantBundle to your application kernel
-------------------------------------------------------

::

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Tristanbes\ElophantBundle\TristanbesElophantBundle(),
            // ...
        );
    }

Configure the bundle
----------------------------------

::

    # app/config/config.yml
    tristanbes_elophant:
        elophant:
            base_url: http://api.elophant.com/v2/
            api_key:  "your_elophant_apikey"
            cache_ttl: 6400
        dashboard:
            max_days: 30
            
            
Then, Upgrade your schema by running (this will create a table named api_call)

::

    app/console doctrine:schema:upgrade --force

.. note::

    Currently elophant does give new API key, but you can find the API documentation here : documentation_ .
    
    If you want other methods of the API implemented, feel free to send a PR


Optionnal statistic dashboard
------------------------------------

If you want to add a dashboard which will display how much api calls were made (including cache, fail and success calls) in your SonataAdminBundle dashboard, i've added a block.

Use it this way: 

1) Import the block :

::

    # app/config/config.yml
    sonata_block:
        ...
        blocks:
            ...
            sonata.block.service.api.elophant:


2) Add the block in your dashboard :

::

    # app/config/config.yml
    sonata_admin:
        dashboard:
            blocks:
                # display a dashboard block
                - { position: left, type: sonata.admin.block.admin_list }
                - { position: right, type: sonata.block.service.api.elophant }
                
3) Publish bundle's assets :

::
    
    app/console assets:install web/ --symlink
    
The graph is rendered using hichart. 
    
    
.. _documentation:      http://www.elophant.com/league-of-legends/api/docs
