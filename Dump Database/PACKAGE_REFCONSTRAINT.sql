--------------------------------------------------------
--  Ref Constraints for Table PACKAGE
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."PACKAGE" ADD CONSTRAINT "PACKAGE_FK1" FOREIGN KEY ("COMPANY_ID")
	  REFERENCES "SYSTEM"."COMPANY" ("ID") ON DELETE CASCADE ENABLE;
