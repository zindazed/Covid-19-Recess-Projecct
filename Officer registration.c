#include<stdio.h>
#include "include/mysql.h"
#include <stdlib.h>
main()
{
// storing variables	
char password1[14];
char password2[14];
char name[23];
int i,j,outofguesses=0,count=0;

//Register and save user name
puts("Enter User Name:");
gets(name);

//Register and save password
puts("Enter password to be saved\n You only have 3 trials !");
gets(password1);

//Store registered details in a separate file
FILE *m;
m= fopen("user","w++");
fprintf(m,"%s %s" , name, password1);

//Trial error count
while(j!=1&&outofguesses==0)
{
	if(count<3){

puts("Enter password again\n");
gets(password2);

i=strcmp(password1,password2);

//Check if login is successful or not
if(i==0)
{
	printf("You have logged in successfully\n");
	j=1;
	count=5;
	break;
}
	count++;
	printf("You are left with %d trial(s)\n",3-count);
}
else
{
outofguesses=3;
}
}
if(count==5)
printf("Successful login");
else
printf("Unsuccessful login attempt");
}
