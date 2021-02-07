#include <mysql.h>
#include <stdio.h>
#include<stdlib.h>
#include <time.h>
#include <unistd.h>
int main() {
   MYSQL *conn;
   MYSQL_RES *res;
   MYSQL_ROW row;

   char *server = "localhost";
   char *user = "root";
   char *password = "";
   char *database = "patients";
   FILE *fp;
   conn = mysql_init(NULL); //initializing the connection variable

   /* Connect to database */
   if(!mysql_real_connect(conn, server, user, password, database, 3308, NULL, 0)){
      fprintf(stderr, "%s\n", mysql_error(conn));
   puts("could not connect");
      exit(1);
   }

   while(1){
         time_t begin = time(NULL);//start the timer
         sleep(300); //wait for 5 minutes
         time_t end = time(NULL); //end the timer
       //after the 5 minutes, load the patient data into the patients table
       if(mysql_query(conn, "LOAD DATA LOCAL INFILE 'test.txt' INTO TABLE patient_table")){
            fprintf(stderr, "%s\n", mysql_error(conn));
            exit(1);
         }
         //delete content from the patient file after 5 minutes
         fp  = fopen("patient.txt", "w");
         fclose(fp);//close the file
   }

return 0;
}

