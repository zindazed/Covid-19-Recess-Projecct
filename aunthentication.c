#include <stdio.h>
#include <mysql.h>
#include <stdlib.h>
#include <string.h>
//authentication
int main(){
// storing variables
   char *passcode = "john"; //will be passed to the function
   char *offname = "yaaaay";
   MYSQL_RES *res;
   MYSQL_ROW row;
   MYSQL *conn;
   char *server = "localhost";
   char *user = "root";
   char *password1 = "";
   char *database = "patients";
   conn = mysql_init(NULL); //initializing the connection variable
   char *query;
   /* Connect to database */
   if(!mysql_real_connect(conn, server, user, password1, database, 3308, NULL, 0)){
      fprintf(stderr, "%s\n", mysql_error(conn)); //message to client here
   puts("could not connect");
      exit(1);
   }
   //building the query
   char str1[100] = "SELECT name, password, retired FROM pats WHERE name = ";
   strcat(str1, offname);
   strcat(str1, " AND password = ");
   strcat(str1, passcode);
   strcat(str1, " AND retired = ");
   strcat(str1, "false");
   //validating
  if(mysql_query(conn,str1)){
     fprintf(stderr, "%s\n", mysql_error(conn)); //message to client here
     exit(1);
    }
    printf("success\n");
   // fetching the result
   // res = mysql_use_result(conn);
   // int i;
   // while((row = mysql_fetch_row(res)) != NULL){
   // 	for (i = 0; i < 3; i++)
   // 	{
   // 		printf("%s\t",row[i]);
   // 	}
   // 	printf("\n");
   // }
   //close the connection
   mysql_free_result(res);
   mysql_close(conn);

return 0;
}
