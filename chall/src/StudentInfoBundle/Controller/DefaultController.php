<?php

namespace StudentInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use StudentInfoBundle\Service\DataOrganizer;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{

    /**
     * @Route("/getStudent", name="getStudentInfo")
     * @Method({"POST"})
     */
    public function getStudent()
    {
        try {
            $id = $this->get('request')->request->get('id');
            $entityManager = $this->getDoctrine()->getManager();
            $dataOragizer = new DataOrganizer($entityManager);
            $result = $dataOragizer->viewStudent($id);
            $studentData = $result[0];
            $studentID = $studentData["id"];
            $studentName = $studentData["name"];
            $studentPhone = $studentData["phonenumber"];
            $studentStream = $studentData["stream"];

//        return new Response(
//        "<html><body>" . "Student ID = ". $studentID . "<br> StudentName = " . $studentName . "<br> Student Phone = "
//        . $studentPhone. " <br> Student Stream = " . $studentStream ."</body></html>");

            //    return new Response(json_encode($result[0]));

            return $this->render('/student.view.html.twig', $result[0]);
        } catch (\Exception $e) {

        }
        return $this->render('/Error.html.twig', array("message" => "Student Info Not Available"));
    }

    /**
     * @Route("/AddEntry", name="addnew")
     * @Method({"POST"})
     */
    public function AddNewStudent()
    {
        try {
            $name = $this->get('request')->request->get('name');
            $phonenumber = $this->get('request')->request->get('phone');
            $stream = $this->get('request')->request->get('stream');

            $entityManager = $this->getDoctrine()->getManager();
            $dataOrganizer = new DataOrganizer($entityManager);
            $studentID = $dataOrganizer->addStudent($name, $phonenumber, $stream);

            $result_object = array("id" => $studentID);

            return $this->render('/AddResult.html.twig', $result_object);
        }catch (\Exception $e){
            return $this->render('/Error.html.twig',array("message"=> "Internal Server Error"));
        }

       }
}
