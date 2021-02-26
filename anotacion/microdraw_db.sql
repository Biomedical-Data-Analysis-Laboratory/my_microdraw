-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2020 a las 08:06:52
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `microdraw`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keyvalue`
--

CREATE TABLE `keyvalue` (
  `UniqueID` int(11) NOT NULL,
  `myTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `myOrigin` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `myKey` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `myValue` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mySlice` int(6) NOT NULL,
  `mySliceName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mySource` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `myUser` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `finished` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `keyvalue`
--

INSERT INTO `keyvalue` (`UniqueID`, `myTimestamp`, `myOrigin`, `myKey`, `myValue`, `mySlice`, `mySliceName`, `mySource`, `myUser`, `finished`) VALUES
(0, '2020-11-12 16:50:28', '{\"appName\":\"microdraw\",\"slice\":\"0\",\"source\":\"images/sus/dzi_images.json\",\"user\":\"test\"}', 'regionPaths', '{\"Regions\":[{\"path\":[\"Path\",{\"applyMatrix\":true,\"segments\":[[137.59722,162.87162],[122.90297,166.82777],[116.12101,175.30522],[116.12101,183.21751],[118.94683,187.73882],[142.6837,191.69496],[162.46442,186.04333],[163.59475,176.43555],[162.46442,173.04457],[156.81279,168.52326],[154.55213,166.2626],[151.72631,165.69744],[140.98821,165.13228],[135.90173,165.13228],[131.94559,165.13228],[131.38043,165.13228]],\"closed\":true,\"fillColor\":[0.29412,0.11765,0.13333,0.5],\"strokeColor\":[0,0,0,0.5],\"strokeScaling\":false}],\"name\":\"Malignant\",\"filename\":\"images/sus/Patient_001.dzi\"}],\"Hash\":\"-3cd9babc\",\"filename\":\"images/sus/Patient_001.dzi\"}', 0, 'images/sus/Patient_001.dzi', 'sus/dzi_images.json', 'test', 0),
(0, '2020-11-13 10:26:19', '{\"appName\":\"microdraw\",\"slice\":\"0\",\"source\":\"images/sus/dzi_images.json\",\"user\":\"test\"}', 'regionPaths', '{\"Regions\":[{\"path\":[\"Path\",{\"applyMatrix\":true,\"segments\":[[137.59722,162.87162],[122.90297,166.82777],[116.12101,175.30522],[116.12101,183.21751],[118.94683,187.73882],[142.6837,191.69496],[162.46442,186.04333],[163.59475,176.43555],[162.46442,173.04457],[156.81279,168.52326],[154.55213,166.2626],[151.72631,165.69744],[140.98821,165.13228],[135.90173,165.13228],[131.94559,165.13228],[131.38043,165.13228]],\"closed\":true,\"fillColor\":[0.29412,0.11765,0.13333,0.5],\"strokeColor\":[0,0,0,0.5],\"strokeScaling\":false}],\"name\":\"Malignant\",\"filename\":\"images/sus/Patient_001.dzi\"},{\"path\":[\"Path\",{\"applyMatrix\":true,\"segments\":[[201.9132,227.56729],[198.33224,228.91015],[193.40843,232.4911],[192.06558,234.28157],[191.61796,237.86253],[191.17034,240.10062],[191.17034,242.33872],[191.17034,243.23396],[192.5132,245.47205],[199.22748,249.053],[201.9132,249.94824],[211.3132,250.84348],[219.81796,249.94824],[225.18939,246.36729],[227.42748,243.68157],[227.8751,237.86253],[226.08463,231.59586],[222.95129,228.01491],[214.44653,222.64348],[209.52272,221.30062],[208.62748,221.30062],[207.28463,221.30062],[205.94177,221.30062],[205.04653,221.74824],[203.70367,223.53872],[202.36082,225.77681],[201.46558,226.67205],[201.01796,227.56729],[200.57034,228.46253]],\"closed\":true,\"fillColor\":[0.13725,0.6902,0.56863,0.2],\"strokeColor\":[0,0,0,0.5],\"strokeScaling\":false}],\"name\":\"Untitled 2\",\"filename\":\"images/sus/Patient_001.dzi\"}],\"Hash\":\"-18752096\",\"filename\":\"images/sus/Patient_001.dzi\"}', 0, 'images/sus/Patient_001.dzi', 'sus/dzi_images.json', 'test', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `labelobservation`
--

CREATE TABLE `labelobservation` (
  `UniqueID` int(11) NOT NULL,
  `MyTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MyUser` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `MySliceName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Observation` varchar(4000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Label` varchar(4000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `UserID` int(25) NOT NULL,
  `Username` varchar(65) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `EmailAddress`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@email.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
