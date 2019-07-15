<?php

	namespace App\Utilities;

	use Symfony\Component\HttpFoundation\RequestStack;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;

	class Recherche{

		private $request;
		private $session;

		public function __construct(SessionInterface $session, RequestStack $request)
		{
			$this->request = $request->getCurrentRequest();
			$this->session = $session;
		}

		public function setRecherche($prefix, $variables = array())
		{

			$return = array();

			foreach ($variables as $value) {

				if(!is_null($this->request->request->get($value))){
					$this->session->set($prefix.''.$value, $this->request->request->get($value));
				}
					
				$return[$value] = $this->session->get($prefix.''.$value);

			}

			return $return;

		}

	}

?>