#include<stdio.h>
main()
{
char password1[14];
char password2[14];
char name[23];
int i,j,outofguesses=0,count=0;


puts("Enter User name");
gets(name);
puts("Enter password to be saved\n You only have 3 trials !");
gets(password1);

while(j!=44&&outofguesses==0)
{
	if(count<3){

puts("Enter password again\n");
gets(password2);

i=strcmp(password1,password2);

if(i==0)
{
	printf("You have logged in successfully\n");
	j=44;
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
