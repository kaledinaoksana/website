<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Covid Project</title>
    <?php include(__DIR__.'/../blocks/head_art.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" />
    <style>
        /* Custom CSS for SQL code formatting */
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }
        .blue-bold {
            font-weight: bold;
            color: blue;
        }
        .br-bold {
            font-weight: bold;
            color: brown;
        }
    </style>
</head> 

<body>
	
    <!-- Navbar -->
    <header>
        <?php include(__DIR__.'/../blocks/nav-bar-page.php') ?>  
    </header>

    <!-- Main -->
	<div class="container-fluid">	
        <div class="main-content-wrapper">
            <div class="container-fluid" >
                <div class="resume-wrapper mx-auto rounded-5" style="background-color: #FFFFFF;">
                    <div class="resume-header px-4 px-lg-5" >
                        <div class="resume-profile-holder text-center">
                            <!-- Content of the Project -->
                            <h2 class="resume-name text-uppercase" style="color: #19202e;">Covid analysis with SQL</h2>

                            <!-- Skills-->
                            <ul class="list-inline" padding="0% 0% 0% 0%">
                                <li class="list-inline-item"><span class="badge resume-skill-badge" style="color: black">MySQL</span></li>
                                <li class="list-inline-item"><span class="badge resume-skill-badge" style="color: black">Azure Data Studio</span></li>
                                <li class="list-inline-item"><span class="badge resume-skill-badge" style="color: black">SSMS</span></li>
                                <li class="list-inline-item"><span class="badge resume-skill-badge" style="color: black">Docker</span></li>   
                                <li class="list-inline-item"><span class="badge resume-skill-badge" style="color: black">SQL</span></li>                         
                            </ul>

                            <!-- Main Part of the Project -->

                            <p>In my project, I utilized data from an open-source dataset on COVID-19 and transferred 
                                it into a database, honing my SQL skills in the process. By leveraging the available 
                                COVID-19 data, I created a well-structured and efficient database using SQL queries. 
                                This allowed me to practice querying, organizing, and analyzing the information, 
                                gaining valuable experience in working with databases and enhancing my SQL proficiency. 
                                Through this project, I developed a deeper understanding of COVID-19 data management and 
                                improved my ability to extract meaningful insights from large datasets.<br>
                            </p>

                            <h3>Preparation</h3>
                            <p>
                            <strong>Step 1:</strong>  Dataset Download: <a href="https://ourworldindata.org/covid-deaths">Open-source dataset on COVID-19</a> 
                            </p><p>
                            <strong>Step 2:</strong> SQL Server Setup on Docker (Mac M1): <a href="https://learn.microsoft.com/ru-ru/sql/linux/quickstart-install-connect-docker?view=sql-server-ver16&pivots=cs1-bash">tutorial</a> 
                            </p><p>
                            <strong>Step 3:</strong> SSMS Launch (Windows 10): server - IPV4_MAC (User name: SA, Password: psw)
                            </p><p>
                            <strong>Step 4:</strong> Azure Data Studio Launch (Mac M1): server - localhost (User name: SA, Password: psw)
                            </p><p>
                            <strong>Step 5:</strong> Data Import into the Database (Mac M1): download extension "Import Wizard" in Azure Data Studio and import DB from .csv
                            </p><p>
                            <br>


                            <h3>SQL queries</h3>

                            <p>Examining Countries with the Highest Infection Rate:</p>
                            <pre><code class="language-sql">
    <span class="blue-bold">SELECT</span>
        location, 
        population, 
        <span class="br-bold">MAX</span>(total_cases) <span class="blue-bold">AS</span> HighestInfectionCount, 
        <span class="br-bold">MAX</span>((total_cases/population)*100) <span class="blue-bold">AS</span> PercentPopulationInfected
    <span class="blue-bold">FROM</span> Covid19..Covid
    <span class="blue-bold">GROUP BY</span> location, population
    <span class="blue-bold">ORDER BY</span> PercentPopulationInfected <span class="blue-bold">DESC</span>

    <img src="../images/HighInfRateByPop.png" class="img-fluid" alt="" style="width: 90%; height: auto;"/>
                            </code></pre>

                            <p>Examining Countries with the Highest Death Count per Population, Sorted by Continent:</p>
                            <pre><code class="language-sql">
    <span class="blue-bold">SELECT</span> location, <span class="br-bold">MAX</span>(total_deaths) <span class="blue-bold">AS</span> TotalDeathCount
    <span class="blue-bold">FROM</span> Covid19..Covid
    <span class="blue-bold">WHERE</span> continent <span class="blue-bold">IS NULL</span>
    <span class="blue-bold">GROUP BY</span> location
    <span class="blue-bold">ORDER BY</span> TotalDeathCount <span class="blue-bold">DESC</span>

    <img src="../images/totaldeathcount.png" class="img-fluid" alt="" style="width:37%; height: auto;"/>
                            </code></pre>

                            <p>Displaying Continents with the Highest Death Count per Population:</p>
                            <pre><code class="language-sql">
    <span class="blue-bold">SELECT</span> continent, <span class="br-bold">MAX</span>(total_deaths) <span class="blue-bold">AS</span> TotalDeathCount
    <span class="blue-bold">FROM</span> Covid19..Covid
    <span class="blue-bold">WHERE</span> continent <span class="blue-bold">IS NULL</span>
    <span class="blue-bold">GROUP BY</span> continent
    <span class="blue-bold">ORDER BY</span> TotalDeathCount <span class="blue-bold">DESC</span>

    <img src="../images/cont.png" class="img-fluid" alt="" style="width: 37%; height: auto;"/>
                            </code></pre>

                            <p>Global information on the total number of COVID-19 infection cases, total number of deaths, and the overall death percentage:</p>
                            <pre><code class="language-sql">
    <span class="blue-bold">SELECT</span> <span class="br-bold">SUM</span>(new_cases) <span class="blue-bold">AS</span> TotalCases, <span class="br-bold">SUM</span>(new_deaths) <span class="blue-bold">AS</span> TotalDeaths,
    <span class="blue-bold">CASE</span> 
        <span class="blue-bold">WHEN </span> <span class="br-bold">SUM</span>(new_cases) = 0 <span class="blue-bold">OR</span> <span class="br-bold">SUM</span>(new_deaths) = 0
        <span class="blue-bold">THEN NULL</span>                         
        <span class="blue-bold">ELSE</span>  <span class="br-bold">SUM</span>(new_deaths)/<span class="br-bold">SUM</span>(new_cases)*100
        <span class="blue-bold">END AS</span>  DeathPercentage
    <span class="blue-bold">FROM</span> Covid19..Covid     
    <span class="blue-bold">WHERE</span> continent <span class="blue-bold">IS NULL</span> 
    <span class="blue-bold">ORDER BY</span> 1

    <img src="../images/global.png" class="img-fluid" alt="" style="width: 50%; height: auto;"/>
    
    <span class="blue-bold">SELECT</span> continent, location, date, population, new_vaccinations, <span class="br-bold">SUM</span>(new_vaccinations) 
    <span class="blue-bold">OVER</span> (<span class="blue-bold">PARTITION BY</span> location <span class="blue-bold">ORDER BY</span> location, date) <span class="blue-bold">AS</span> RollingPeopleVaccinated
    <span class="blue-bold">FROM</span> Covid19..Covid
    <span class="blue-bold">WHERE</span> continent <span class="blue-bold">IS NULL</span>
    <span class="blue-bold">ORDER BY</span> 2,3
                            </code></pre>

                            <h4>Use CTE</h4>
                            <pre><code class="language-sql">
    <span class="blue-bold">WITH</span> PopvsVac(Continent, Location, Date, Population,new_vaccinations, RollingPeopleVaccinated)
    <span class="blue-bold">AS</span>
    (
        <span class="blue-bold">SELECT</span> continent, location, date, population, new_vaccinations, <span class="br-bold">SUM</span>(new_vaccinations) 
        <span class="blue-bold">OVER</span> (<span class="blue-bold">PARTITION BY</span> location <span class="blue-bold">ORDER BY</span> location, date) <span class="blue-bold">AS</span> RollingPeopleVaccinated
        <span class="blue-bold">FROM</span> Covid19..Covid
        <span class="blue-bold">WHERE</span> continent <span class="blue-bold">IS NULL</span>
    )
    <span class="blue-bold">SELECT</span> *, (RollingPeopleVaccinated/Population)*100
    <span class="blue-bold">FROM</span> PopvsVac
    <span class="blue-bold">WHERE</span> location <span class="blue-bold">LIKE</span> '%Russia%'
    <span class="blue-bold">ORDER BY</span> 2,3
                            </code></pre>

                            <h4>Temp Table</h4>
                            <pre><code class="language-sql">
    <span class="blue-bold">DROP TABLE IF EXISTS</span> #PercentPopulationVaccinated
    <span class="blue-bold">USE</span> Covid19
    <span class="blue-bold">GO</span>
    <span class="blue-bold">CREATE VIEW</span> PercentPopulationVaccinated <span class="blue-bold">AS</span> 
        <span class="blue-bold">SELECT</span> continent, location, date, population, new_vaccinations, <span class="br-bold">SUM</span>(new_vaccinations) 
        <span class="blue-bold">OVER</span> (<span class="blue-bold">PARTITION BY</span> location <span class="blue-bold">ORDER BY</span> location, date) <span class="blue-bold">AS</span> RollingPeopleVaccinated
        <span class="blue-bold">FROM</span> Covid19..Covid
        <span class="blue-bold">WHERE</span> continent <span class="blue-bold">IS NULL</span>
                            </code></pre>










                            <!-- Botton NEXT --> 
                            <div class="actions d-flex justify-content-center " style="padding: 5%">
                                <a href="crypto.php" class="button" style="color: #1E2738;">
                                    <h3 class="resume-section-heading text-uppercase m-2 align-items-center" style="color: #1E2738;">
                                        <i class="fas fa-eye mr-2"></i>View Next Project
                                    </h3>
                                </a>
                            </div>  
                            <!-- END Botton NEXT -->   
                        </div>
                    </div>
                </div>         
            </div><!--//container-fluid-->
        </div><!--//main-content-wrapper-->
	</div><!--//container-->
	
    <!-- Footer -->
	<footer class="footer text-center py-4">
		<small class="copyright" style="color: #FFFFFF">2023 </span><i class="bi bi-heart-fill" style="color:#fe655c"></i> </small>
	</footer>


</body>