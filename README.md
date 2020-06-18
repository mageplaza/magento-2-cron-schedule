# Magento 2 Cron Schedule extension Free

[Cron Schedule from Mageplaza](https://www.mageplaza.com/magento-2-cron-schedule/) is one of the most utility which helps you to execute tasks with no effort from the admin panel. The extension prevents errors from popping up, avoid interruption as well as create a smooth flow for your store’s performance. 


## 1. Documentation
- [Installation guide](https://www.mageplaza.com/install-magento-2-extension/)
- [User guide](https://docs.mageplaza.com/cron-schedule/index.html)
- [Introduction page](http://www.mageplaza.com/magento-2-cron-schedule/)
- [Contribute on Github](https://github.com/mageplaza/magento-2-cron-schedule)
- [Get Support](https://github.com/mageplaza/magento-2-cron-schedule/issues)


## 2. FAQ

**Q: I got an error: Mageplaza_Core has been already defined**

A: Read solution [here](https://github.com/mageplaza/module-core/issues/3)

**Q: I would like to locate our Fanpage on any places on the sites. Is it possible?**

A: Yes. Please create Facebook Widget from Block section from the backend,  then embed it on any CMS page or block. 

**Q: What can I do with Cron Jobs Grid?**

A: You can view all available cron jobs details at the Cron Jobs Grid, including cron job code, group name, activation status, instance classpath, job method, time schedule, and action. Also, you can edit quickly the cron jobs you created from this grid. Besides, the extension supports mass actions such as delete, change status, and execute. 

**Q: What can I see at Cron Jobs Log?**

A: You can view all states of any cron tasks. You will be well-notified when a cron task gets Error, Missed, Pending, Running, Success. If the process has the problems, the log will display a message containing all error details, and you can identify and resolve to make it run properly. 

**Q: Can I schedule to clear the log frequently?** 

A: Yes, of course. At the admin backend, you can define the time to clean up the log frequently such as every 10 minutes, every 30 minutes, etc. to keep the record neat. 

**Q: What are the benefits of Cron Jobs Timetable?**

A: Cron Jobs Timetable gives you the power to manage cron tasks visually in chronological order. Color bars are used to mark the scheduled time and notice the state of running cron jobs, for example, red for errors, blue for pending, purple for running, green for success. When hovering over a particular bar, a detail box will appear for you to see more details. 

**Q: When there are errors, how can I know?**

A: There will be a notification about cron errors sent to you quickly if you turn on Backend Notification and Email Notification. 

**Q: Can I run cron jobs manually?**

A: Yes, at the Cron Jobs Grid, please choose cron jobs and click on Execute at Action box. 

 ## 3. How to install Cron Schedule extension for Magento 2
 
**Install via composer (recommend)**

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-cron-schedule
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## 4. Highlight Features

### Monitor all cronjobs at the admin panel

From the backend, store admins can track and manage the scheduled cron jobs from a separate listing grid. It is flexible to access the grid to monitor cron jobs details including cron job code, group name, activation status, instance classpath, job method, time schedule, and action. The cron jobs grid provides an overview of all available cron tasks. Admins can make a quick edit to the cron jobs created before from this grid. 

![Imgur](https://i.imgur.com/xFG2nxA.png)
 
Admins can also perform mass actions on cron tasks or on selected ones, including deleting, changing the status of cron tasks without any difficulties. 


### Record all states of a cron task

![Imgur](https://i.imgur.com/NxfsmV6.png)

Another outstanding feature of Cron Schedule is that it allows recording and updating all status of a cron task in History Log. 

Store admins will be notified by the Cron Jobs Log when there are action states, including Error, Missed, Pending, Running, and Success. If there are any problems, a message showing all details of errors will be displayed on the log. Admins can reconfigure to solve the problem. 

### Make cron tasks visual in a timetable

![Imgur](https://i.imgur.com/Vs9Cv0c.png)

It is necessary to arrange and display cron jobs with different schedule time and status in an easy-to-follow and logical way, which helps store admins to manage the cron jobs grid easily. Cron Timetable and Table wisely display all cron tasks in chronological order with fully setting dates and time of each cron task. 

Notably, each of the cron tasks is set up along with a specific color bar showing the visual status, which makes it easier for store admins to identify the state. For example, red color illustrates errors, blue color for pending, purple for running, and green for success. In case, tasks affect each other; admin can easily define and timely modify them. 

### Manually carry out cron jobs 

![Imgur](https://i.imgur.com/yfnvG1c.png)

Cron jobs can be run smoothly by applying "Execute" at the Action box. Manual execution makes the process of updating cron tasks more active and straightforward for store admins. 

## 5. More Features

### Multiple Actions
Remove, execute, or change the status of various cron jobs at once 

### Backend notification
Enable/ Disable notifications at the backend if cron get errors or missed out

### Notification emails
Enable/ Disable email notification to admin when cron jobs get errors or missed out

### Email schedule

Schedule auto-send emails

### Automatically clear log 
Set time to automatically clear up the log (such as every 30 minutes, etc.)

### Multiple store views
View and manage cron jobs at various store views at Cron Jobs grid or timetable. 


## 6. Full Features Lists 

### Configuration 

- Enable/ Disable notifications at the backend if cron get errors or missed 
- Enable/ Disable email notification to admin when cron jobs get errors or lost  
- Choose email senders 
- Complete admins’ emails 
- Choose email templates 
- Automated email sending schedule
- Schedule auto clearing log (such as every 30 minutes, etc.)

### Cron Jobs Grid
- Check all details of available cron jobs: Cron Job Code, Group Name, Status, Instance Classpath, Job Method, Time Schedule, and Action.
- Multiple actions (delete, change status, execute) on multiple cron jobs 
- Make a change of store view
- Cover/ Uncover grid columns

### Create/ Edit Cron Jobs
- Add the cron job code 
- Choose group name 
- Allow/ Disallow the cron job
- Fill in job method
- Use cron format to add schedule time

### Cron Jobs Log 
- See result states of cron jobs clearly including Error, Missed, Pending, Running, and Success.
- View other related details: ID, Job Code, Status, Message, Total Executed Time, Created At, Scheduled At, Executed At, Finished At, Action.
- Eliminate cron jobs 
- Filter, change store view, show/ hide columns 

### Cron Jobs Timetable 
- See result states of cron jobs in details at the timetable format 
- Choose when to display cron jobs: last 24 hours, last 7 days, last 30 days

## 7. User Guide


### How to use

#### Admin can receive notification message when running cron job gets error: 

![](https://i.imgur.com/HllkaCk.png)

#### Email admin when running cron jobs, Missed and Error:

![](https://i.imgur.com/QOUziv1.png)


#### Show detail Cron Job when hovering on green bars - Crons run successfully

![](https://i.imgur.com/On7L9VN.png)

#### Show detail Cron Job when hovering on blue bars - Crons are waiting for approval to run

![](https://i.imgur.com/XGjOcPW.png)

#### Show detail Cron Job when hovering on red bars - Crons run failed

![](https://i.imgur.com/shswdJc.png)

#### Show detail Cron Job when hovering on red bars - Crons are miss run

![](https://i.imgur.com/g0gTT7Z.png)

#### Show detail Cron Job when hovering on purple bars - Crons are running

![](https://i.imgur.com/R0NTuly.png)

### How to Configure

From the Admin Panel, go to `System > Cron Schedule > Configuration`

![](https://i.imgur.com/fjtqdz6.png)

#### 1. Configuration

From the Admin Panel, go to `System > Cron Schedule > Configuration`, select **General**

![](https://i.imgur.com/hMLkQhi.png)

- **Backend Notifications**: Select **Yes** to display a notification when running cron jobs is fails.

![](https://i.imgur.com/UtcBEpL.png)

  - When admin click on **Here** will be directed to the **Cron Jobs Log** page.
  
- **Email Notifications**:
  - Select **Yes** to send a notification to admin when running cron jobs, report only **Missed** and **Error** Crons.
  - Install [Mageplaza SMTP](https://www.mageplaza.com/magento-2-smtp/) to avoid email sent to spam box.
- **Sender**: Select the representative to send the email to notify the customer:

![](https://i.imgur.com/ZUJdZeO.png)

- **Send To**:
  - Enter the admin email address.
  - You can enter multiple emails, each separated by commas (,).
    
- **Email Template**:
  - Select Email template sent automatically to admin.
  - You can access `Marketing > Email Templates`, select **Add New Templates** to create a notification email template
  - Instructions on how to create new email templates can be found [here](https://www.mageplaza.com/kb/how-to-customize-email-template-transactional-email-magento-2.html)
  
- **Schedule For Email**: Choose the time to send an email error message after cron jobs finish:

![](https://i.imgur.com/9AKHU5y.png)

- **Auto Clear Log Every**: 
  - Set the time to auto clear log. Calculated by day.
  - If Empty or 0, the cron jobs log will not be clean.


#### 2. Grid

There are three methods to run Cron manually:
- Method 1: Run the command: `php bin/magento cron:run`
- Method 2: Click **Run All Cron Jobs** at **Manage Cron Jobs** Page.
- Method 3: Tick to choose the Cron Jobs you want to check at **Manage Cron Jobs** table, then choose **Action = Execute**.

**Note**:

- First time running Cron, all the cron schedules are in Pending Status. You can view them at **cron_schedule** table or **Cron Jobs Log** Page. 

- The second time running Cron, there are two cases:
  - The cron schedule will be Executed if its starting time is over current time but still smaller than 2 mins (The time set at field **Missed If Not Run Within**)
  - The cron schedule will be assigned as Missed status if its starting time is over 2 mins 

- You can view or change the Missed Time by:
 
From the Admin Panel, go to `Stores > Configuration > Advanced > System > Cron`, change it in the field **Missed If Not Run Within**

![](https://i.imgur.com/agun0FO.png)

##### 2.1. Manage Cron Jobs

From the Admin Panel, go to `System > Cron Schedule > Manage Cron Jobs`

![](https://i.imgur.com/v9GJh07.png)

- This is where Cron Jobs information is displayed.
- From **Manage Cron Jobs**, admin can capture basic information such as **Cron Job Code, Group Name, Status, Instance Classpath, Job Method, Time Schedule, Action**.
- **Action**:
  - **Delete**: Delete information on **Manage Cron Jobs** page.
  - **Change Status**: Change the status of selected Cron Jobs.
  - **Execute**: Running Cron Jobs.
  - **Edit**: Navigate to the edit page for information Cron Jobs created earlier. Only show **Edit** button with the crons created by admin. Not editable with premade crons. 
- **Run All Cron Jobs**: run all Cron Jobs in the table.
- In addition, admin can filter, change store view, hide/ display columns.

##### 2.2. Create New Cron Jobs

From the Admin Panel, go to `System > Cron Schedule > Manage Cron Jobs`, select **Add New**

![](https://i.imgur.com/yHp5jDL.png)

- **Cron Job Code**:
  - Enter the code of Cron Jobs.
  - This is a required field.
- **Group Name**:

![](https://i.imgur.com/GvZ9oWf.png)

- Choose the group suitable for cron job applying
- In which:
  - All groups are available on Magento EE 2.2.x
  - Magento CE 2.1.x only has two groups: Default and Index
  - Magento CE 2.2.x has three groups: Default, Index and Ddg_automation
  - Magento CE 2.3.x has four groups: Default, Index, Ddg_automation and Consumers
  
- **Status**: Select **Enable** for Cron Jobs to work.
- **Instance Classpath**:
  - Enter the path to the object, or called **namespace**
  - This is a required field.
  - Example: `Mageplaza\CronSchedule\Model\Test`

- **Job Method**:
  - Enter the Method name (Each object has several methods to fill in this field)
  - This is a required field.
  - Example: execute, recurring billing
  
- **Time Schedule**:
  - Enter the runtime of Cron Jobs.
  - Using Cron format [here](http://www.nncron.ru/help/EN/working/cron-format.htm) to set time for running cron job.
  - This is a required field.
  - Example: * * * * * means that cron will be run once every minute.


#### 3. Cron Jobs Log

- From the Admin Panel, go to `System > Cron Schedule > Cron Jobs Log`

![](https://i.imgur.com/eHy1n39.png)

- This is where the Cron Jobs information is displayed running in 5 states: Error, Missed, Pending, Running, Success.
- From **Cron Jobs Log**, admin can capture basic information such as ID, Job Code, Status, Message, Total Executed Time, Created At, Scheduled At, Executed At, Finished At, Action.
- **Action**:
  - **Delete**: Delete the information on the **Cron Jobs Log** page.
  - **View**: View detailed information of running **Job Code**, only can see the cron jobs created by admin.
  - **Clear All**: Delete the entire history of running Cron Jobs before.
- In addition, admin can filter, change store view, hide/ display columns.

#### 4. Cron Jobs Timetable

From the Admin Panel, go to `System > Cron Schedule > Cron Jobs Timetable`

![](https://i.imgur.com/9fjMt7a.png)

- This is the Timetable display page of the Cron Jobs Log page. It plays the role of a chart report helping admin to know the results of the cron running process. 

- **Select Time**: Select the time to display Cron Jobs.



## 8. License

From June 23th 2019, this extension is licensed under the [MIT License](https://github.com/mageplaza/magento-2-cron-schedule/blob/master/LICENSE)
