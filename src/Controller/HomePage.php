<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\Type\MovieFormType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomePage extends AbstractController
{
    /**
     * 
     * @Route("/movies", name="movies")
     * 
     */
    public function apiCalls(Request $request, EntityManagerInterface $em) {
    $allMovies=$em->getRepository(Movie::class)->findAll();
    $response= new JsonResponse();
    $response->setData([
        'success'=> true,
        "data"=> dd($allMovies)
    ]
        
        );
    return $response;
}

    /**
     * 
     * @Route("/newMovie", name="new Movie")
     * API_KEY=b3a462eee4bd41e621f1cc64385984c8
     */
    public function newMovie(Request $request, EntityManagerInterface $em, Environment $twig){
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $movie_id = $form->get('title')->getData();
            $ci= curl_init();
            curl_setopt($ci, CURLOPT_URL, "https://api.themoviedb.org/3/movie/".$movie_id."?api_key=b3a462eee4bd41e621f1cc64385984c8&language=en-US");
            curl_setopt($ci, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ci, CURLOPT_HEADER, 0); 
            $data=curl_exec($ci);
            $datadecoded=json_decode($data,true);
            $existsMovie = $em->getRepository(Movie::class)->findOneBy(array('movie_id'=> $movie_id));
            if($existsMovie){
                $response= new JsonResponse();
                $response->setData([
                    'success'=> false,
                    "data"=>  "This movie exists on your DB"
              ]);
                    return $response;
            }else{
            foreach($datadecoded as $key=>$value)
            { 
                if($key == "adult"){
                    $movie->setAdult($value);    
                }elseif($key == "backdrop_path"){
                    $movie->setBackdropPath($value);
                }elseif($key == "belongs_to_collection"){
                    if(is_array($value)){
                        $movie->setBelongsToColection(true);
                    }else{
                        $movie->setBelongsToColection(false);
                    }
                }elseif($key == "budget"){
                    $movie->setBudget($value);
                }elseif($key == "genres"){
                    $array = [];
                    foreach($value as $key2=>$value2){
                        foreach ($value2 as $key3=>$value3){
                        if($key3 == 'name'){
                            $movie->setGenres($value3);
                        }
                        
                    }
                }
                }elseif($key == "homepage"){
                    $movie->setHomepage($value);
                }elseif($key == "id"){
                    $movie->setMovieId($movie_id);
                }elseif($key == "original_language"){
                    $movie->setOriginalLanguage($value);
                }elseif($key == "original_title"){
                    $movie->setOriginalTitle($value);
                }elseif($key == "overview"){
                    $movie->setOverview($value);
                }elseif($key == "popularity"){
                    $movie->setPopularity($value);
                }elseif($key == "poster_path"){
                    $movie->setPosterPath($value);
                }elseif($key == "production_companies"){
                    $array = [];
                    foreach($value as $key2=>$value2){
                        if($key2 == "name"){
                            array_push($array,$value2);
                            echo $key2;
                        }
                    }
                    // $string = implode(",",$array);
                    // $movie->setProductionCompanies($string);
                }elseif($key == "production_countries"){
                    $array = [];
                    foreach($value as $key2=>$value2){
                        if($key2 == "name"){
                            array_push($array,$value2);
                        }
                    }
                    // $string = implode(",",$array);
                    // $movie->setProductionCountries($string);
                }elseif($key == "release_date"){
                    $movie->setReleaseDate($value);
                }elseif($key == "revenue"){
                    $movie->setRevenue($value);
                }elseif($key == "runtime"){
                    $movie->setRuntime($value);
                }elseif($key == "status"){
                    $movie->setStatus($value);
                }elseif($key == "tagline"){
                    $movie->setTagline($value);
                }elseif($key == "title"){
                    $movie->setTitle($value);
                }elseif($key == "video"){
                    $movie->setVideo($value);
                }elseif($key == "vote_average"){
                    $movie->setVoteAverage($value);
                };
                $em->persist($movie);
            }
            $em->flush();
            $response= new JsonResponse();
            $response->setData([
                'success'=> true,
                "data"=>  "Perfect, this movie is now on your DB"
          ]);
                return $response;
        }}
        return new Response 
        ($twig->render('movie/show.html.twig', [
            'movie_form'=>$form->createView(),
        ]));
    ;}
    
};