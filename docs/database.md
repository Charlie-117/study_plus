# Databse design

1. Table name: edu  
   Description: Details about registered educators
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Primary Key | Email of educator |
| 2 | name | varchar(255) | Not null | Name of educator |
| 3 | password | varchar(255) | Not null | Password associated with the email |    

  
      


2. Table name: eduCode  
   Description: Details about courses created by educators
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Not null | Email of educator |
| 2 | code | int | Primary key | Course code |
| 3 | course | varchar(255) | Not null | Name of course |
| 4 | course_desc | varchar(1024) | Not null | Description of course |

  
     


3. Table name: eduCard  
   Description: Details about flashcards created by educators
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | course_code  | int | Foreign Key | Course code |
| 2 | card_id | int | Primary key | Flashcard id |
| 3 | card_name | varchar(1024) | Not null | Name of flashcard |
| 4 | card_desc | varchar(10000) | Not null | Content of flashcard |

  
      


4. Table name: eduQzName  
   Description: Details about Quizzes created by educators
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | course_code  | int | Foreign Key | Course code |
| 2 | quiz_id | int | Primary key | Quiz id |
| 3 | quiz_name | varchar(1024) | Not null | Name of quiz |

  
    


5. Table name: eduQuiz  
   Description: Quiz questions and their answers for quizzes created by educators
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | course_code  | int | Foreign Key | Course code |
| 2 | quiz_id | int | Primary key | Quiz id |
| 3 | quiz_ qstn _id | int | Not null | Quiz question id |
| 4 | quiz_qstn | varchar(255) | Not null | Question |
| 5 | opt_a | varchar(255) | Not null | Option A |
| 6 | opt_b | varchar(255) | Not null | Option B |
| 7 | opt_c | varchar(255) | Not null | Option C |
| 8 | opt_d | varchar(255) | Not null | Option D |
| 9 | quiz_ans | varchar(255) | Not null | Answer |

  
     


6. Table name: eduVid  
   Description: Details about Videos created by educators

   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | course_code  | int | Foreign Key | Course code |
| 2 | video_id | int | Primary key | Video id |
| 3 | video_name | varchar(255) | Not null | Name of Video |
| 4 | video_url | varchar(255) | Not null | YouTube URL of video |

  
       


7. Table name: stud  
   Description: Details about registered Students
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Primary Key | Email of student |
| 2 | name | varchar(255) | Not null | Name of student |
| 3 | password | varchar(255) | Not null | Password associated with the email |

  
      


8. Table name: studCode  
   Description: Details of courses in which Students are enrolled
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Foreign key | Email of student |
| 2 | code | int | Foreign key | Course code |

  
    


9. Table name: studQuiz  
   Description: Details of quizzes played by students
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Foreign key | Email of student |
| 2 | course_code | int | Foreign key | Course code |
| 3 | quiz_id | int | Foreign key | Quiz id |

  
        


10. Table name: studScore  
   Description: Score of students by course
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Foreign Key | Email of student |
| 2 | course_code | int | Foreign key | Course code |
| 3 | score | int | Default = 0 | Score of student in course |

  
        


11. Table name: studVid  
   Description: Details of videos watched by students
   
| #  | name | Data type | Constraints |  Description |
| ------------- | ------------- | ------------- |------------- |------------- |
| 1  | email  | varchar(255) | Foreign Key | Email of student |
| 2 | course_code | int | Foreign key | Course code |
| 3 | video_id | int | Foreign key | Video id |




