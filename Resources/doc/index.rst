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

.. note::

    Currently elophant does give new API key, but you can find the API documentation here : documentation_


.. _documentation:      http://www.elophant.com/league-of-legends/api/docs
