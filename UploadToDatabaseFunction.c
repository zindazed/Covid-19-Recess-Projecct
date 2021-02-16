#include <mysql.h>
#include <string.h>
#include <stdio.h>
#include<stdlib.h>
#include <time.h>
#include <unistd.h>
int main(){
   MYSQL *conn; //mysql connection variable
   MYSQL_RES *res;
   MYSQL_ROW row;

   char *server = "sql5.freemysqlhosting.net"; //remote mysql server address
   char *user = "sql5392531"; //remote mysql username
   char *password = "NcjJcFdr3c"; //remote mysql server password
   char *database = "sql5392531";//remote mysql database name
   conn = mysql_init(NULL); //initializing the connection variable

   // Connecting to the database
   puts("connecting to mysql server...");
   if(!mysql_real_connect(conn, server, user, password, database, 3306, NULL, 0)){
      fprintf(stderr, "%s\n", mysql_error(conn));
      puts("could not connect");
      exit(1);
   }
   puts("connected");

  while(1){
    time_t begin = time(NULL);//start the timer
    sleep(300); //wait for 5 minutes
    time_t end = time(NULL); //end the timer
    puts("timer done");
    //after timer, we upload content inthe enrollment file to the remote mysql database
  char str[100];
  char *arry[6];
  char *t;
  int h;
  FILE *fp; //file pointer to the enrollment file
  char query1[1024]; //variable to store the query for upload
  fp = fopen("enrollmentfile.txt", "r");
  if (fp==NULL)
  {
    puts("failed to open the file");
    exit(1);
  }
  while(fgets(str, 100, fp) != NULL){ //getting record by record from the enrollment file
   // puts(str);
    t = strtok(str, " ");
    h = 0;
    //putting elements from a record into an arrar
    while(t!=0){
    arry[h++] = t;
    t = strtok(0, " ");
    }
    printf("\n%s and %s and %s and %s and %s", arry[0], arry[1], arry[2], arry[3], arry[4]);
    //exit(1);
    //building the query
    snprintf(query1, sizeof(query1), "INSERT INTO patients (patient_name, date_of_identification, category, gender, case_type) VALUES ('%s','%s','%s','%s','%s')", arry[0],arry[1],arry[2],arry[3],arry[4]);

    if(mysql_query(conn, query1)){ //running the uploadtodatabase query
       fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
     }
     puts("query successful");
     fclose(fp);
     fp = fopen("enrollmentfile.txt", "w"); //deleting the enrollmentfile content
     fclose(fp);
    }
  }
return 0;
}

// "LOAD DATA LOCAL INFILE 'enrollmentfile.txt' INTO TABLE patients FIELDS TERMINATED BY ' '
